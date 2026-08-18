<?php

namespace App\Services\FrontEnd;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function addToCart(array $data): array
    {

        $product = Product::find($data['product_id']);

        if (!$product || $product->status != 1) {

            return [
                'status' => false,
                'message' => 'Product not available.',
            ];
        }

        $variant = ProductVariant::where('id', $data['product_variant_id'])
            ->where('product_id', $data['product_id'])
            ->first();


        if (!$variant) {
            return [
                'status' => false,
                'message' => 'Variant not found for this product.',
            ];
        }

        if (is_null($variant->size_id)) {
            return [
                'status' => false,
                'message' => 'Selected size does not match the variant.',
            ];
        }

        if (is_null($variant->color_id)) {
            return [
                'status' => false,
                'message' => 'Selected color does not match the variant.',
            ];
        }

        if ($variant->stock_status !== 'in_stock') {
            return [
                'status' => false,
                'message' => 'Product is out of stock.',
            ];
        }

        if ($variant->manage_stock && $variant->stock_quantity < $data['product_quantity']) {
            return [
                'status' => false,
                'message' => 'Not enough stock available.',
            ];
        }

        $sessionId = Session::get('session_id');

        if (!$sessionId) {
            $sessionId = Session::getId();
            Session::put('session_id', $sessionId);
        }


        if (Auth::check()) {
            $userId = Auth::id();

            $exists = Cart::where([
                'user_id' => $userId,
                'product_id' => $data['product_id'],
                'product_variant_id' => $variant->id,
            ])->exists();
        } else {

            $userId = null;

            $exists = Cart::where([
                'session_id' => $sessionId,
                'product_id' => $data['product_id'],
                'product_variant_id' => $variant->id,
            ])->exists();
        }


        if ($exists) {
            return [
                'status' => false,
                'message' => 'Product already exists in cart.',
            ];
        }

        $cart = Cart::create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'product_id' => $data['product_id'],
            'product_variant_id' => $variant->id,
            'product_quantity' => $data['product_quantity'],
        ]);


        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->count();
        } else {
            $cartCount = Cart::where('session_id', $sessionId)->count();
        }

        return [
            'status' => true,
            'message' => 'Product added successfully to cart.',
            'cart_id' => $cart->id,
            'cart_count' => $cartCount,
        ];
    }
}
