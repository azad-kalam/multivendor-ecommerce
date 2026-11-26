<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\Transaction;
use App\Services\FrontEnd\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function create()
    {
        return view('frontend.checkout.create');
    }


    public function store(Request $request)
    {
        $validatedData = $this->validated($request);

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        $cartData = $this->cartService->index_cart();

        if (empty($cartData['items'])) {
            return back()->withErrors([
                'cart' => 'Your cart is empty.',
            ]);
        }

        $subtotal = (float) $cartData['subtotal'];
        $productDiscount = (float) $cartData['product_discount'];

        $couponCode = Session::get('coupon_code');

        try {
            $order = DB::transaction(function () use (
                $validatedData,
                $userId,
                $subtotal,
                $productDiscount,
                $couponCode
            ) {
                $coupon = null;
                $couponDiscount = 0;

                if ($couponCode) {
                    $couponResult = $this->cartService->apply_coupon($couponCode, $subtotal, $productDiscount);
                    if (!$couponResult['status']) {
                        throw ValidationException::withMessages([
                            'coupon' => $couponResult['message'],
                        ]);
                    }
                    $coupon = $couponResult['coupon'];
                    $couponDiscount = (float) $couponResult['coupon_discount'];
                }

                $grandTotal = round(max(0, $subtotal - $productDiscount - $couponDiscount), 2);
                $shippingAddress = ShippingAddress::create([
                    'user_id' => $userId,
                    'name' => $validatedData['name'],
                    'phone' => $validatedData['phone'],
                    'country' => $validatedData['country'],
                    'division' => $validatedData['division'],
                    'district' => $validatedData['district'],
                    'thana' => $validatedData['thana'],
                    'area' => $validatedData['area'],
                    'postal_code' => $validatedData['postal_code'],
                    'street_address' => $validatedData['street_address'],
                ]);

                if ($validatedData['billing_same_as_shipping'] ?? false) {
                    $billingData = [
                        'user_id' => $userId,
                        'name' => $shippingAddress->name,
                        'phone' => $shippingAddress->phone,
                        'country' => $shippingAddress->country,
                        'division' => $shippingAddress->division,
                        'district' => $shippingAddress->district,
                        'thana' => $shippingAddress->thana,
                        'area' => $shippingAddress->area,
                        'postal_code' => $shippingAddress->postal_code,
                        'street_address' => $shippingAddress->street_address,
                    ];
                } else {
                    $billingData = [
                        'user_id' => $userId,
                        'name' => $validatedData['billing_name'],
                        'phone' => $validatedData['billing_phone'],
                        'country' => $validatedData['billing_country'],
                        'division' => $validatedData['billing_division'],
                        'district' => $validatedData['billing_district'],
                        'thana' => $validatedData['billing_thana'],
                        'area' => $validatedData['billing_area'],
                        'postal_code' => $validatedData['billing_postal_code'],
                        'street_address' => $validatedData['billing_street_address'],
                    ];
                }

                $billingAddress = BillingAddress::create($billingData);
                $order = Order::create([
                    'user_id' => $userId,
                    'shipping_address_id' => $shippingAddress->id,
                    'billing_address_id' => $billingAddress->id,
                    'coupon_id' => $coupon?->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(12)),
                    'order_status' => 'pending',
                    'subtotal' => $subtotal,
                    'product_discount' => $productDiscount,
                    'coupon_discount' => $couponDiscount,
                    'total_amount' => $grandTotal,
                ]);

                $transactionCode = $this->generateTransactionCode($validatedData['payment_method']);
                $order->transaction()->create([
                    'user_id' => $userId,
                    'transaction_code' => $transactionCode,
                    'payment_method' => $validatedData['payment_method'],
                    'payment_status' => 'unpaid',
                    'paid_at' => null,
                ]);

                if ($coupon) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => $userId,
                        'order_id' => $order->id,
                        'used_count' => 1,
                    ]);
                }
                return $order;
            }, 3);
        } catch (ValidationException $exception) {

            return redirect()
                ->route('frontend.checkout.create')
                ->withErrors($exception->errors())
                ->withInput();
        } catch (\Throwable $exception) {

            Log::error('Order creation failed', [
                'user_id' => $userId,
                'exception' => $exception,
            ]);

            return redirect()
                ->route('frontend.checkout.create')
                ->with('toastr_error', 'Something went wrong! Please try again.');
        }

        Session::forget([
            'coupon_code',
            'coupon_discount',
        ]);

        return redirect()
            ->route('frontend.checkout.create')
            ->with('toastr_success', 'Order successfully completed!');
    }

    protected function validated(Request $request): array
    {
        $rules = [
            'name' => 'required|string|max:100',
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/',
            ],

            'country' => 'required|in:BD',
            'division' => 'required|integer|min:1',
            'district' => 'required|integer|min:1',
            'thana' => 'required|integer|min:1',
            'area' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'street_address' => 'required|string|max:255',
            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_name' => 'required_unless:billing_same_as_shipping,1|string|max:100',
            'billing_phone' => [
                'required_unless:billing_same_as_shipping,1',
                'string',
                'max:20',
                'regex:/^(?:\+?88)?01[3-9]\d{8}$/',
            ],
            'billing_country' => 'required_unless:billing_same_as_shipping,1|in:BD',
            'billing_division' => 'required_unless:billing_same_as_shipping,1|integer|min:1',
            'billing_district' => 'required_unless:billing_same_as_shipping,1|integer|min:1',
            'billing_thana' => 'required_unless:billing_same_as_shipping,1|integer|min:1',
            'billing_area' => 'required_unless:billing_same_as_shipping,1|string|max:100',
            'billing_postal_code' => 'required_unless:billing_same_as_shipping,1|string|max:10',
            'billing_street_address' => 'required_unless:billing_same_as_shipping,1|string|max:255',
            'payment_method' => 'required|in:bkash,nagad,rocket,bank,stripe,cash',
        ];

        return $request->validate($rules, [
            'name.required' => 'Please enter your name.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex' => 'Please enter a valid Bangladesh phone number.',
            'country.required' => 'Please select your country.',
            'division.required' => 'Please select your division.',
            'district.required' => 'Please select your district.',
            'thana.required' => 'Please select your thana.',
            'area.required' => 'Please select your area.',
            'postal_code.required' => 'Please enter your postal code.',
            'street_address.required' => 'Please enter your street address.',
            'billing_name.required_unless' => 'Please enter billing name.',
            'billing_phone.required_unless' => 'Please enter billing phone.',
            'billing_country.required_unless' => 'Please select billing country.',
            'billing_division.required_unless' => 'Please select billing division.',
            'billing_district.required_unless' => 'Please select billing district.',
            'billing_thana.required_unless' => 'Please select billing thana.',
            'billing_area.required_unless' => 'Please enter billing area.',
            'billing_postal_code.required_unless' => 'Please enter billing postal code.',
            'billing_street_address.required_unless' => 'Please enter billing street address.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'Please select a valid payment method.',
        ]);
    }

    public function generateTransactionCode(string $paymentMethod): string
    {
        $prefixCode = match (strtolower($paymentMethod)) {
            'bkash'  => 'BKA',
            'nagad'  => 'NAG',
            'rocket' => 'ROK',
            'bank'   => 'BNK',
            'stripe' => 'STR',
            'cash'   => 'CSH',
            default  => 'TXN',
        };
        $attempts = 0;
        $maxAttempts = 5;
        do {
            $code = $prefixCode . strtoupper(Str::random(10));
            $exists = Transaction::where('transaction_code', $code)->exists();
            $attempts++;
            if (!$exists) {
                return $code;
            }
        } while ($attempts < $maxAttempts);

        throw new RuntimeException(
            'Unable to generate a unique transaction code.'
        );
    }
}
