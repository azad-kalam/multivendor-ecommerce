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
    /*
    |--------------------------------------------------------------------------
    | Cart Index
    |--------------------------------------------------------------------------
    */

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


        /*
        |--------------------------------------------------------------------------
        | Cart Query
        |--------------------------------------------------------------------------
        */

        $cartQuery = Cart::query()
            ->with([
                'product',
                'variant.images',
                'variant.color',
                'variant.size',
            ]);


        /*
        |--------------------------------------------------------------------------
        | User / Guest Cart
        |--------------------------------------------------------------------------
        */

        if ($userId) {

            $cartQuery->where(
                'user_id',
                $userId
            );
        } else {

            $cartQuery->where(
                'session_id',
                $sessionId
            );
        }


        $cartRows = $cartQuery
            ->orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Initialize
        |--------------------------------------------------------------------------
        */

        $items = [];

        $subtotal = 0;

        $productDiscount = 0;

        $couponDiscount = 0;

        $grandTotal = 0;


        /*
        |--------------------------------------------------------------------------
        | Cart Items
        |--------------------------------------------------------------------------
        */

        foreach ($cartRows as $cartRow) {

            $product = $cartRow->product;

            $variant = $cartRow->variant;


            if (!$product || !$variant) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Price Data
            |--------------------------------------------------------------------------
            */

            $priceData =
                $this->getVariantPrice($variant);


            $regularPrice =
                (float) $priceData['regular_price'];


            $sellingPrice =
                (float) $priceData['selling_price'];


            $discountValue =
                (float) $priceData['discount_value'];


            /*
            |--------------------------------------------------------------------------
            | Quantity
            |--------------------------------------------------------------------------
            */

            $productQuantity =
                max(
                    1,
                    (int) $cartRow->product_quantity
                );


            /*
            |--------------------------------------------------------------------------
            | Calculations
            |--------------------------------------------------------------------------
            |
            | Price = Regular Price × Quantity
            |
            */

            $itemPrice =
                round(
                    $regularPrice * $productQuantity,
                    2
                );


            /*
            |--------------------------------------------------------------------------
            | Discount
            |--------------------------------------------------------------------------
            |
            | Discount = Discount × Quantity
            |
            */

            $itemDiscount =
                round(
                    $discountValue * $productQuantity,
                    2
                );


            /*
            |--------------------------------------------------------------------------
            | Total
            |--------------------------------------------------------------------------
            |
            | Total = Selling Price × Quantity
            |
            */

            $itemTotal =
                round(
                    $sellingPrice * $productQuantity,
                    2
                );


            /*
            |--------------------------------------------------------------------------
            | Summary
            |--------------------------------------------------------------------------
            */

            $subtotal += $itemPrice;

            $productDiscount += $itemDiscount;

            $grandTotal += $itemTotal;


            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            $image =
                $variant->images
                ->first()?->public_path;


            /*
            |--------------------------------------------------------------------------
            | Item Data
            |--------------------------------------------------------------------------
            */

            $items[] = [

                'id' =>
                $cartRow->id,

                'product_id' =>
                $product->id,

                'variant_id' =>
                $variant->id,

                'image' =>
                $image,

                'product_name' =>
                $product->name,

                'color_name' =>
                $variant->color?->name,

                'size_name' =>
                $variant->size?->name,

                'product_quantity' =>
                $productQuantity,

                /*
                |--------------------------------------------------------------------------
                | Price = Regular Price × Quantity
                |--------------------------------------------------------------------------
                */

                'item_price' =>
                $itemPrice,

                /*
                |--------------------------------------------------------------------------
                | Discount = Discount × Quantity
                |--------------------------------------------------------------------------
                */

                'discount' =>
                $itemDiscount,

                /*
                |--------------------------------------------------------------------------
                | Total = Selling Price × Quantity
                |--------------------------------------------------------------------------
                */

                'cart_quantity_price' =>
                $itemTotal,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Final Summary
        |--------------------------------------------------------------------------
        */

        $finalSubtotal =
            round(
                $subtotal,
                2
            );


        $totalProductDiscount =
            round(
                $productDiscount,
                2
            );


        $grandTotal =
            round(
                $grandTotal,
                2
            );


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return [

            'items' =>
            $items,

            'subtotal' =>
            $finalSubtotal,

            'product_discount' =>
            $totalProductDiscount,

            'coupon_discount' =>
            $couponDiscount,

            'grand_total' =>
            $grandTotal,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Create Cart
    |--------------------------------------------------------------------------
    */

    public function create_cart(array $data): array
    {
        $productId =
            (int) (
                $data['product_id'] ?? 0
            );


        $variantId =
            (int) (
                $data['product_variant_id'] ?? 0
            );


        $quantity =
            (int) (
                $data['product_quantity'] ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Product ID
        |--------------------------------------------------------------------------
        */

        if ($productId < 1) {

            return [

                'status' => false,

                'message' =>
                'Product ID is not valid.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Variant ID
        |--------------------------------------------------------------------------
        */

        if ($variantId < 1) {

            return [

                'status' => false,

                'message' =>
                'Product variant ID is not valid.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Quantity
        |--------------------------------------------------------------------------
        */

        if ($quantity < 1) {

            return [

                'status' => false,

                'message' =>
                'Quantity must be at least 1.',
            ];
        }


        $userId =
            Auth::id();


        /*
        |--------------------------------------------------------------------------
        | Session
        |--------------------------------------------------------------------------
        */

        $sessionId =
            Session::get('session_id');


        if (!$sessionId) {

            $sessionId =
                Session::getId();

            Session::put(
                'session_id',
                $sessionId
            );
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            $product =
                Product::query()
                ->where(
                    'id',
                    $productId
                )
                ->where(
                    'status',
                    1
                )
                ->first();


            if (!$product) {

                return [

                    'status' => false,

                    'message' =>
                    'Product is not available.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Variant
            |--------------------------------------------------------------------------
            */

            $variant =
                ProductVariant::query()
                ->where(
                    'id',
                    $variantId
                )
                ->where(
                    'product_id',
                    $productId
                )
                ->first();


            if (!$variant) {

                return [

                    'status' => false,

                    'message' =>
                    'Product variant was not found.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Stock Status
            |--------------------------------------------------------------------------
            */

            if (
                $variant->stock_status !==
                'in_stock'
            ) {

                return [

                    'status' => false,

                    'message' =>
                    'Product variant is out of stock.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Manage Stock
            |--------------------------------------------------------------------------
            */

            if (
                $variant->manage_stock &&
                (int) $variant->stock_quantity < $quantity
            ) {

                return [

                    'status' => false,

                    'message' =>
                    'Only ' .
                        $variant->stock_quantity .
                        ' items are available.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Create Cart
            |--------------------------------------------------------------------------
            */

            $cart =
                DB::transaction(
                    function () use (
                        $productId,
                        $variantId,
                        $quantity,
                        $userId,
                        $sessionId
                    ) {

                        $cartQuery =
                            Cart::query()
                            ->where(
                                'product_id',
                                $productId
                            )
                            ->where(
                                'product_variant_id',
                                $variantId
                            );


                        if ($userId) {

                            $cartQuery->where(
                                'user_id',
                                $userId
                            );
                        } else {

                            $cartQuery->where(
                                'session_id',
                                $sessionId
                            );
                        }


                        $existingCart =
                            $cartQuery
                            ->lockForUpdate()
                            ->first();


                        if ($existingCart) {

                            return [

                                'status' =>
                                false,

                                'message' =>
                                'Product already exists in cart.',

                                'cart' =>
                                null,
                            ];
                        }


                        $newCart =
                            Cart::create([

                                'user_id' =>
                                $userId,

                                'session_id' =>
                                $sessionId,

                                'product_id' =>
                                $productId,

                                'product_variant_id' =>
                                $variantId,

                                'product_quantity' =>
                                $quantity,
                            ]);


                        return [

                            'status' =>
                            true,

                            'message' =>
                            'Product added successfully to cart.',

                            'cart' =>
                            $newCart,
                        ];
                    }
                );


            if (!$cart['status']) {

                return [

                    'status' =>
                    false,

                    'message' =>
                    $cart['message'],
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Cart Count
            |--------------------------------------------------------------------------
            */

            $cartCountQuery =
                Cart::query();


            if ($userId) {

                $cartCountQuery->where(
                    'user_id',
                    $userId
                );
            } else {

                $cartCountQuery->where(
                    'session_id',
                    $sessionId
                );
            }


            $cartCount =
                $cartCountQuery->count();


            return [

                'status' =>
                true,

                'message' =>
                'Product added successfully to cart.',

                'cart_id' =>
                $cart['cart']->id,

                'cart_count' =>
                $cartCount,
            ];
        } catch (\Throwable $e) {

            report($e);

            return [

                'status' =>
                false,

                'message' =>
                'Sorry, product could not be added to cart.',
            ];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update Cart Quantity
    |--------------------------------------------------------------------------
    */

    public function update(
        int $cart_id,
        int $product_quantity
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Session
        |--------------------------------------------------------------------------
        */

        $sessionId =
            Session::get('session_id');


        if (!$sessionId) {

            $sessionId =
                Session::getId();

            Session::put(
                'session_id',
                $sessionId
            );
        }


        $userId =
            Auth::id();


        /*
        |--------------------------------------------------------------------------
        | Find Cart
        |--------------------------------------------------------------------------
        */

        $cart_row =
            Cart::with([
                'product',
                'variant.images',
                'variant.color',
                'variant.size',
            ])
            ->where(
                'id',
                $cart_id
            )
            ->when(
                $userId,
                function ($query) use ($userId) {

                    $query->where(
                        'user_id',
                        $userId
                    );
                }
            )
            ->when(
                !$userId,
                function ($query) use ($sessionId) {

                    $query->where(
                        'session_id',
                        $sessionId
                    );
                }
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Cart Not Found
        |--------------------------------------------------------------------------
        */

        if (!$cart_row) {

            return [

                'status' => false,

                'message' =>
                'Cart item not found.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Variant
        |--------------------------------------------------------------------------
        */

        $variant =
            $cart_row->variant;


        if (!$variant) {

            return [

                'status' => false,

                'message' =>
                'Product variant not found.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Quantity Validation
        |--------------------------------------------------------------------------
        */

        if ($product_quantity < 1) {

            return [

                'status' => false,

                'message' =>
                'Quantity must be at least 1.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Stock Validation
        |--------------------------------------------------------------------------
        */

        if (
            $variant->manage_stock &&
            $product_quantity >
            (int) $variant->stock_quantity
        ) {

            return [

                'status' => false,

                'message' =>
                'Maximum available stock is ' .
                    $variant->stock_quantity .
                    '.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Get Price
        |--------------------------------------------------------------------------
        */

        $priceData =
            $this->getVariantPrice(
                $variant
            );


        $regularPrice =
            (float) (
                $priceData['regular_price'] ?? 0
            );


        $sellingPrice =
            (float) (
                $priceData['selling_price'] ?? 0
            );


        $discountValue =
            (float) (
                $priceData['discount_value'] ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Update Database Quantity
        |--------------------------------------------------------------------------
        */

        $cart_row->product_quantity =
            $product_quantity;

        $cart_row->save();


        /*
        |--------------------------------------------------------------------------
        | Current Item Calculations
        |--------------------------------------------------------------------------
        |
        | Price = Regular Price × Quantity
        |
        */

        $itemPrice =
            round(
                $regularPrice *
                    $product_quantity,
                2
            );


        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */

        $itemDiscount =
            round(
                $discountValue *
                    $product_quantity,
                2
            );


        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        |
        | Total = Selling Price × Quantity
        |
        */

        $itemTotal =
            round(
                $sellingPrice *
                    $product_quantity,
                2
            );


        /*
        |--------------------------------------------------------------------------
        | Get All Cart Items
        |--------------------------------------------------------------------------
        */

        $cart_items =
            Cart::with('variant')
            ->when(
                $userId,
                function ($query) use ($userId) {

                    $query->where(
                        'user_id',
                        $userId
                    );
                }
            )
            ->when(
                !$userId,
                function ($query) use ($sessionId) {

                    $query->where(
                        'session_id',
                        $sessionId
                    );
                }
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Summary Initialize
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        $totalDiscount = 0;


        /*
        |--------------------------------------------------------------------------
        | Calculate Summary
        |--------------------------------------------------------------------------
        */

        foreach ($cart_items as $cart_item) {

            if (!$cart_item->variant) {
                continue;
            }


            $itemPriceData = $this->getVariantPrice($cart_item->variant);

            $itemRegularPrice = (float) ($itemPriceData['regular_price'] ?? 0);
            $itemDiscountPrice = (float) ($itemPriceData['discount_value'] ?? 0);
            $quantity = max(1, (int) $cart_item->product_quantity);

            $subtotal += $itemRegularPrice * $quantity;
            $totalDiscount += $itemDiscountPrice * $quantity;
        }

        $couponDiscount = 0;
        $subtotal = round($subtotal, 2);
        $totalDiscount = round($totalDiscount, 2);
        $grandTotal = round($subtotal - $totalDiscount - $couponDiscount, 2);

        return [
            'status' => true,
            'message' => 'Cart quantity updated successfully.',

            'cart' => [
                'cart_id' => $cart_row->id,
                'quantity' => $product_quantity,
                'item_price' => $itemPrice,
                'regular_price' => $regularPrice,
                'selling_price' => $sellingPrice,
                'item_discount' => $itemDiscount,
                'item_total' => $itemTotal,
            ],

            'summary' => [
                'subtotal' => $subtotal,
                'product_discount' => $totalDiscount,
                'coupon_discount' => $couponDiscount,
                'grand_total' => $grandTotal,
            ],
        ];
    }


    public function delete_cart(int $id)
    {
        $query = Cart::where('id', $id);

        $authenticatedUser = Auth::check();

        if ($authenticatedUser) {

            $authId = Auth::id();
            $query->where('user_id', $authId);
        } else {

            $sessionId = Session::get('session_id');

            if (!$sessionId) {
                $sessionId = Session::getId();
                Session::put('session_id', $sessionId);
            }

            $query->where('session_id', $sessionId);
        }

        $cart = $query->firstOrFail();

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
