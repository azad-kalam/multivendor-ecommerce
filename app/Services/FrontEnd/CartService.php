<?php

namespace App\Services\FrontEnd;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class CartService
{
    public function addToCart(array $data): array
    {
        $productId = (int) ($data['product_id']);
        $variantId = (int) ($data['product_variant_id']);
        $data_quantity = (int) ($data['product_quantity']);

        if ($productId < 1) {
            return [
                'status' => false,
                'message' => 'Product ID not valid.',
            ];
        }

        if ($variantId < 1) {
            return [
                'status' => false,
                'message' => 'Variant ID not valid.',
            ];
        }

        if ($data_quantity < 1) {
            return [
                'status' => false,
                'message' => 'Quantity must be at least 1.',
            ];
        }

        $sessionId = Session::get('session_id');

        if (!$sessionId) {
            $sessionId = Session::getId();
            Session::put('session_id', $sessionId);
        }

        $userId = Auth::id();

        try {

            $product = Product::query()
                ->whereKey($productId)
                ->where('status', 1)
                ->first();

            if (!$product) {
                return [
                    'status' => false,
                    'message' => 'Product status is not active.',
                ];
            }

            $variant = ProductVariant::query()
                ->whereKey($variantId)
                ->where('product_id', $productId)
                ->first();

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

            if ($variant->manage_stock && $variant->stock_quantity < $data_quantity) {
                return [
                    'status' => false,
                    'message' => $variant->stock_quantity . ' items are available.',
                ];
            }

            $cart = DB::transaction(function () use ($productId, $variantId, $data_quantity, $userId, $sessionId, $variant) {
                $cartQuery = Cart::query()
                    ->where('product_id', $productId)
                    ->where('product_variant_id', $variantId);

                if ($userId) {
                    $cartQuery->where('user_id', $userId);
                } else {

                    $cartQuery->where('session_id', $sessionId);
                }

                $cart = $cartQuery->lockForUpdate()->first();

                if ($cart) {
                    $newQuantity = (int) $cart->product_quantity + $data_quantity;
                    if ($variant->manage_stock && $variant->stock_quantity < $newQuantity) {
                        throw new \Exception(
                            'Only ' . $variant->stock_quantity . ' items are available.'
                        );
                    }

                    $cart->update([
                        'product_quantity' => $newQuantity,
                    ]);
                } else {

                    $cart = Cart::create([
                        'user_id' => $userId,
                        'session_id' => $sessionId,
                        'product_id' => $productId,
                        'product_variant_id' => $variantId,
                        'product_quantity' => $data_quantity,
                    ]);
                }

                return $cart;
            });

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
                'cart_id' => $cart->id,
                'cart_count' => $cartCount,
            ];
        } catch (\Exception $e) {

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        } catch (Throwable $e) {

            report($e);
            return [
                'status' => false,
                'message' => 'Sorry, Product could not add to cart.',
            ];
        }
    }


    public function index_cart(): array
    {
        $sessionId = Session::get('session_id');

        if (!$sessionId) {
            $sessionId = Session::getId();
            Session::put(
                'session_id',
                $sessionId
            );
        }

        $userId = Auth::id();

        $cartQuery = Cart::query()
            ->with([
                'product',
                'variant.images',
                'variant.color',
                'variant.size',
            ]);

        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }

        $cartRows = $cartQuery->orderByDesc('id')->get();

        $items = [];
        $subtotal = 0;
        $totalDiscount = 0;
        $grandTotal = 0;

        foreach ($cartRows as $cartRow) {
            $product = $cartRow->product;
            $variant = $cartRow->variant;

            if (!$product || !$variant) {
                continue;
            }

            $priceData = $this->getVariantPrice($variant);
            $regularPrice = $priceData['regular_price'];
            $sellingPrice = $priceData['selling_price'];
            $discountAmount = $priceData['discount_amount'];
            $productQuantity = max(1, (int) $cartRow->product_quantity);
            $itemSubtotal = round($regularPrice * $productQuantity, 2);
            $itemDiscount = round($discountAmount * $productQuantity, 2);
            $itemTotal = round($sellingPrice * $productQuantity, 2);

            $subtotal += $itemSubtotal;
            $totalDiscount += $itemDiscount;
            $grandTotal += $itemTotal;
            $image = $variant->images->first()?->public_path;

            $items[] = [
                'id' => $cartRow->id,
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'product_name' => $product->name,
                'color_name' => $variant->color?->name,
                'size_name' => $variant->size?->name,
                'product_quantity' => $productQuantity,
                'regular_price' => $regularPrice,
                'selling_price' => $sellingPrice,
                'price' => $sellingPrice,
                'discount' => $discountAmount,
                'discount_amount' => $discountAmount,
                'discount_type' => $variant->discount_type,
                'discount_value' => $variant->discount_value,
                'item_subtotal' => $itemSubtotal,
                'cart_quantity_price' => $itemTotal,
                'image' => $image,
            ];
        }

        $subtotal = round($subtotal, 2);
        $totalDiscount = round($totalDiscount, 2);
        $grandTotal = round(max(0, $subtotal - $totalDiscount), 2);

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $totalDiscount,
            'grand_total' => $grandTotal,
        ];
    }

    private function getVariantPrice(ProductVariant $variant): array
    {
        $regularPrice = (float) $variant->regular_price;
        $sellingPrice = (float) $variant->selling_price;
        $discountType = $variant->discount_type;
        $discountAmount = max(0, $regularPrice - $sellingPrice);

        $now = now();

        $discountStarted = !$variant->discount_start || $now->gte($variant->discount_start);
        $discountNotExpired = !$variant->discount_end || $now->lte($variant->discount_end);
        $discountActive = $discountStarted && $discountNotExpired;

        if (!$discountActive) {
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $regularPrice,
                'discount_amount' => 0,
            ];
        }

        if ($discountType === 'none') {
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $regularPrice,
                'discount_amount' => 0,
            ];
        }

        if ($discountType === 'fixed' || $discountType === 'percent') {
            return [
                'regular_price' => $regularPrice,
                'selling_price' => $sellingPrice,
                'discount_amount' => $discountAmount,
            ];
        }

        return [
            'regular_price' => $regularPrice,
            'selling_price' => $regularPrice,
            'discount_amount' => 0,
        ];
    }
}
