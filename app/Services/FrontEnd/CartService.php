<?php

namespace App\Services\FrontEnd;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function index_cart(): array
    {
        $sessionId = Session::get('session_id');

        if (!$sessionId) {
            $sessionId = Session::getId();
            Session::put('session_id', $sessionId);
        }

        $userId = Auth::id();

        $cartQuery = Cart::query()->with(['product', 'variant.images', 'variant.color', 'variant.size',]);

        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }

        $cartRows = $cartQuery->orderBy('id', 'asc')->get();

        $items = [];
        $subtotal = 0;
        $productDiscount = 0;
        $couponDiscount = 0;
        $grandTotal = 0;

        foreach ($cartRows as $cartRow) {
            $product = $cartRow->product;
            $variant = $cartRow->variant;
            if (!$product || !$variant) {
                continue;
            }

            $priceData = $this->getVariantPrice($variant);
            $regularPrice = (float) $priceData['regular_price'];
            $sellingPrice = (float) $priceData['selling_price'];
            $discountValue = (float) $priceData['discount_value'];
            $productQuantity = max(1, (int) $cartRow->product_quantity);

            $itemPrice = round($regularPrice * $productQuantity, 2);
            $itemDiscount = round($discountValue * $productQuantity, 2);
            $itemTotal = round($sellingPrice * $productQuantity, 2);

            $subtotal += $itemPrice;
            $productDiscount += $itemDiscount;
            $grandTotal += $itemTotal;

            $image = $variant->images->first()?->public_path;

            $items[] = [
                'id' => $cartRow->id,
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'image' => $image,
                'product_name' => $product->name,
                'color_name' => $variant->color?->name,
                'size_name' => $variant->size?->name,
                'product_quantity' => $productQuantity,
                'item_price' => $itemPrice,
                'item_discount' => $itemDiscount,
                'item_total' => $itemTotal,
            ];
        }

        $finalSubtotal = round($subtotal, 2);
        $totalProductDiscount = round($productDiscount, 2);
        $grandTotal = round($grandTotal, 2);

        return [
            'items' => $items,
            'subtotal' => $finalSubtotal,
            'product_discount' => $totalProductDiscount,
            'coupon_discount' => $couponDiscount,
            'grand_total' => $grandTotal,
        ];
    }


    public function create_cart(array $data): array
    {
        $productId = (int) ($data['product_id'] ?? 0);
        $variantId = (int) ($data['product_variant_id'] ?? 0);
        $quantity = (int) ($data['product_quantity'] ?? 0);

        if ($productId < 1) {
            return [
                'status' => false,
                'message' => 'Product ID is not valid.',
            ];
        }

        if ($variantId < 1) {
            return [
                'status' => false,
                'message' => 'Product variant ID is not valid.',
            ];
        }

        if ($quantity < 1) {
            return [
                'status' => false,
                'message' => 'Quantity must be at least 1.',
            ];
        }

        $userId = Auth::id();
        $sessionId = Session::get('session_id');

        if (!$sessionId) {
            $sessionId = Session::getId();
            Session::put('session_id', $sessionId);
        }

        try {
            $product = Product::query()->where('id', $productId)->where('status', 1)->first();
            if (!$product) {
                return [
                    'status' => false,
                    'message' => 'Product is not available.',
                ];
            }

            $variant = ProductVariant::query()->where('id', $variantId)->where('product_id', $productId)->first();
            if (!$variant) {
                return [
                    'status' => false,
                    'message' => 'Product variant was not found.',
                ];
            }

            if ($variant->stock_status !== 'in_stock') {
                return [
                    'status' => false,
                    'message' => 'Product variant is out of stock.',
                ];
            }

            if ($variant->manage_stock && (int) $variant->stock_quantity < $quantity) {
                return [
                    'status' => false,
                    'message' => 'Only ' . $variant->stock_quantity . ' items are available.',
                ];
            }

            $cart = DB::transaction(
                function () use ($productId, $variantId, $quantity, $userId, $sessionId) {
                    $cartQuery = Cart::query()
                        ->where('product_id', $productId)
                        ->where('product_variant_id', $variantId);

                    if ($userId) {
                        $cartQuery->where('user_id', $userId);
                    } else {
                        $cartQuery->where('session_id', $sessionId);
                    }

                    $existingCart = $cartQuery->lockForUpdate()->first();
                    if ($existingCart) {
                        return [
                            'status' => false,
                            'message' => 'Product already exists in cart.',
                            'cart' => null,
                        ];
                    }

                    $newCart = Cart::create([
                        'user_id' => $userId,
                        'session_id' => $sessionId,
                        'product_id' => $productId,
                        'product_variant_id' => $variantId,
                        'product_quantity' => $quantity,
                    ]);

                    return [
                        'status' => true,
                        'message' => 'Product added to cart successfully.',
                        'cart' => $newCart,
                    ];
                }
            );

            if (!$cart['status']) {
                return [
                    'status' => false,
                    'message' => $cart['message'],
                ];
            }

            $cartCountQuery = Cart::query();

            if ($userId) {
                $cartCountQuery->where('user_id', $userId);
            } else {
                $cartCountQuery->where('session_id', $sessionId);
            }

            $cartCount = $cartCountQuery->count();

            return [
                'status' => true,
                'message' => 'Product added successfully to cart.',
                'cart_id' => $cart['cart']->id,
                'cart_count' => $cartCount,
            ];
        } catch (\Throwable $error) {
            report($error);
            return [
                'status' => false,
                'message' => 'Sorry, product could not be added to cart.',
            ];
        }
    }

    public function update_cart(int $cartId, int $product_quantity): array
    {
        $userId = Auth::id();
        $sessionId = null;

        if (!$userId) {
            $sessionId = Session::get('session_id');

            if (!$sessionId) {
                $sessionId = Session::getId();
                Session::put('session_id', $sessionId);
            }
        }

        $cartRow = Cart::query()
            ->where('id', $cartId)
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when(!$userId, function ($query) use ($sessionId) {
                $query->where('session_id', $sessionId);
            })
            ->first();

        if (!$cartRow) {
            return [
                'status' => false,
                'message' => 'Cart item not found.',
            ];
        }

        if ($product_quantity < 1) {
            return [
                'status' => false,
                'message' => 'Minimum quantity must be 1.',
            ];
        }
        $variant = ProductVariant::query()
            ->where('id', $cartRow->product_variant_id)
            ->first();

        if (!$variant) {
            return [
                'status' => false,
                'message' => 'Product variant not found.',
            ];
        }
        if ($variant->stock_status !== 'in_stock') {
            return [
                'status' => false,
                'message' => 'Product variant is out of stock.',
            ];
        }
        if ($variant->manage_stock && $product_quantity > (int) $variant->stock_quantity) {
            return [
                'status' => false,
                'message' => "Maximum quantity is available {$variant->stock_quantity}.",
            ];
        }

        $cartRow->product_quantity = $product_quantity;
        $cartRow->save();
        return [
            'status' => true,
            'message' => 'Cart item updated successfully.',
        ];
    }


    public function delete_cart(int $cartId)
    {
        $cartQuery = Cart::where('id', $cartId);

        $authenticatedUser = Auth::check();

        if ($authenticatedUser) {
            $authId = Auth::id();
            $cartQuery->where('user_id', $authId);
        } else {
            $sessionId = Session::get('session_id');
            if (!$sessionId) {
                $sessionId = Session::getId();
                Session::put('session_id', $sessionId);
            }
            $cartQuery->where('session_id', $sessionId);
        }

        $cart = $cartQuery->firstOrFail();

        $cart->delete();
        return $cart;
    }

    private function getVariantPrice(ProductVariant $variant): array
    {
        $regularPrice = (float) $variant->regular_price;
        $sellingPrice = (float) $variant->selling_price;
        $discountType = $variant->discount_type;
        $discountValue = (float) $variant->discount_value;

        $now = now();

        $discountStarted = !$variant->discount_start || $now->gte($variant->discount_start);
        $discountNotExpired = !$variant->discount_end || $now->lte($variant->discount_end);
        $discountActive = $discountStarted && $discountNotExpired;

        if (!$discountActive) {
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $regularPrice,
                'discount_value' => 0,
            ];
        }

        if ($discountType === 'none') {
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $regularPrice,
                'discount_value' => 0,
            ];
        }

        if ($discountType === 'fixed') {
            $sellingPrice = max(0, $regularPrice - $discountValue);
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $sellingPrice,
                'discount_value' => $discountValue,
            ];
        }

        if ($discountType === 'percent') {
            $discount = ($regularPrice * $discountValue) / 100;
            $sellingPrice = max(0, $regularPrice - $discount);
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $sellingPrice,
                'discount_value' => $discount,
            ];
        }

        return [
            'regular_price' => $regularPrice,
            'selling_price' => $regularPrice,
            'discount_value' => 0,
        ];
    }
}
