<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Image;
use App\Models\Product;
use App\Models\Price;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function show_product_detailsWith_subcategory_related(int $id)
    {
        $product = Product::with([
            'images',
            'brand',
            'category',
            'subcategory',
            'productModel',

            'variants' => function ($query) {
                $query
                    ->where('stock_status', 'in_stock')
                    ->with([
                        'size',
                        'color',
                        'images',
                    ]);
            },
        ])
            ->where('status', 1)
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Variant Data For JavaScript
        |--------------------------------------------------------------------------
        */

        $variantData = $product->variants
            ->map(function ($variant) {

                return [
                    'id' => $variant->id,

                    'product_id' => $variant->product_id,

                    'size_id' => $variant->size_id,

                    'color_id' => $variant->color_id,

                    'regular_price' => (float) $variant->regular_price,

                    'selling_price' => (float) $variant->selling_price,

                    'discount_type' => $variant->discount_type,

                    'discount_value' => (float) ($variant->discount_value ?? 0),

                    'discount_start' => $variant->discount_start,

                    'discount_end' => $variant->discount_end,

                    'manage_stock' => (bool) $variant->manage_stock,

                    'stock_quantity' => (int) ($variant->stock_quantity ?? 0),

                    'stock_status' => $variant->stock_status,

                    'images' => $variant->images
                        ->map(function ($img) {
                            return asset($img->public_path);
                        })
                        ->values()
                        ->toArray(),
                ];
            })
            ->values()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Related Products
        |--------------------------------------------------------------------------
        */

        $relatedProducts = Product::with([
            'images',
            'subcategory',

            'variants' => function ($query) {

                $query
                    ->where('stock_status', 'in_stock')
                    ->select([
                        'id',
                        'product_id',
                        'color_id',
                        'size_id',
                        'regular_price',
                        'selling_price',
                        'discount_type',
                        'discount_value',
                        'discount_start',
                        'discount_end',
                        'stock_quantity',
                        'stock_status',
                        'manage_stock',
                    ]);
            },
        ])
            ->where('subcategory_id', $product->subcategory_id)
            ->where('status', 1)
            ->whereKeyNot($product->id)
            ->latest()
            ->get();


        return view(
            'frontend.product_details.product_detailsWith_subcategory_related',
            compact(
                'product',
                'variantData',
                'relatedProducts'
            )
        );
    }
}
