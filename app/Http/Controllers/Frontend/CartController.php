<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontEnd\CartRequest;
use App\Services\FrontEnd\CartService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use app\Models\Coupon;


class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return view('frontend.carts.index');
    }

    public function store(CartRequest $request)
    {
        $validatedData = $request->validated();
        $resultData = $this->cartService->create_cart($validatedData);

        if (!$resultData['status']) {
            return response()->json($resultData, 422);
        }
        return response()->json($resultData, 200);
    }


    public function update(CartRequest $request, int $cartId)
    {
        $validatedData = $request->validated();
        $result = $this->cartService->update_cart($cartId, $validatedData['product_quantity']);

        if (!$result['status']) {
            return response()->json($result, 422);
        }
        return $this->render_cart_and_summary($result['message']);
    }


    public function destroy(int $cartId)
    {
        $result = $this->cartService->delete_cart($cartId);
        if (!$result['status']) {
            return response()->json($result, 422);
        }
        return $this->render_cart_and_summary($result['message']);
    }


    public function render_cart_and_summary(string $message = 'cart refresh')
    {
        $cartData = $this->cartService->index_cart();
        $cartTable = view('frontend.carts.AJAX.ajax_cart_item', [
            'cart_items' => $cartData['items'],
        ])->render();

        $cartSummary = view('frontend.carts.AJAX.ajax_cart_summary', [
            'subtotal' => $cartData['subtotal'],
            'product_discount' => $cartData['product_discount'],
            'coupon_discount' => $cartData['coupon_discount'],
            'grand_total' => $cartData['grand_total'],
        ])->render();

        return response()->json([
            'status' => true,
            'message' => $message,
            'cart_item_quantity' => cart_item_quantity(),
            'cart_table' => $cartTable,
            'cart_summary' => $cartSummary,
        ]);
    }


    public function apply_coupon(Request $request)
    {
        $validated = $request->validate(
            [
                'coupon_code' => ['required', 'string', 'max:30'],
            ],
            [
                'coupon_code.required' => 'Please enter a coupon code.',
                'coupon_code.string'   => 'Coupon code must be a valid string.',
                'coupon_code.max'      => 'Coupon code cannot exceed 30 characters.',
            ]
        );

        $couponCode = trim($validated['coupon_code']);

        $coupon = Coupon::where('coupon_code', $couponCode)->first();
        Session::put('coupon_data', [
            'coupon_code' => $coupon['coupon_code'],
            'discount_type' => $coupon['discount_type'],
            'discount_value' => $coupon['discount_value'],
        ]);

        if (! $coupon) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'Invalid coupon code.'])
                ->with('toastr_error', 'Invalid coupon code.');
        }

        if ((int) $coupon->status !== 1) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'This coupon is inactive.'])
                ->with('toastr_error', 'This coupon is inactive.');
        }

        if ($coupon->start_at && $coupon->start_at > now()) {
            $message = 'Coupon will start on ' . $coupon->start_at->format('d-M-Y');
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => $message])
                ->with('toastr_error', $message);
        }

        if ($coupon->expire_at && $coupon->expire_at < now()) {
            $message = 'Coupon expired on ' . $coupon->expire_at->format('d-M-Y');
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => $message])
                ->with('toastr_error', $message);
        }

        if ($coupon->total_usage_limit !== null && (int) $coupon->coupon_used >= (int) $coupon->total_usage_limit) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'Usage limit has been reached.'])
                ->with('toastr_error', 'Usage limit has been reached.');
        }

        if ($coupon->discount_type === 'percentage' && (float) $coupon->discount_value > 100) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'Percentage cannot exceed 100%.'])
                ->with('toastr_error', 'Percentage cannot exceed 100%.');
        }

        if (! is_numeric($coupon->discount_value) || (float) $coupon->discount_value <= 0) {
            return back()
                ->withInput()
                ->withErrors(['coupon_code' => 'Invalid discount value.'])
                ->with('toastr_error', 'Invalid discount value.');
        }

        Session::forget('coupon_id');
        Session::put('coupon_code', $coupon->coupon_code);

        return back()->with('toastr_success', 'Coupon applied successfully.');
    }
}
