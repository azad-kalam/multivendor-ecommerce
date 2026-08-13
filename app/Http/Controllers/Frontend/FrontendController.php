<?php

namespace App\Http\Controllers\Frontend;

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
                $query->where('stock_status', 'in_stock')
                    ->with([
                        'size',
                        'color',
                        'images',
                    ]);
            },
        ])
            ->where('status', 1)
            ->findOrFail($id);

        $relatedProducts = Product::with([
            'images',
            'subcategory',
            'variants' => function ($query) {

                $query->where('stock_status', 'in_stock')
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
                        'stock_status'
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
                'relatedProducts'
            )
        );
    }











    public function category_wise_product_show(int $id)
    {
        $latestProducts = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();

        $categories = Category::with('subcategories')
            ->select('id', 'name')
            ->where('status', 1)
            ->latest()
            ->get();

        $category_wise_products = Category::with(
            'subcategories.products.images',
            'subcategories.products.price'
        )->findOrFail($id);

        $brand_names = Product::where('status', 1)
            ->whereNotNull('brand')
            ->orderBy('brand', 'asc')
            ->pluck('brand')
            ->map(fn($item) => trim($item))
            ->unique()
            ->values();

        $brand_products = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->orderBy('brand', 'asc')
            ->limit(16)
            ->get()
            ->groupBy('brand');

        return view('frontend.category_wise_product', compact('category_wise_products', 'latestProducts', 'categories', 'brand_names', 'brand_products'));
    }

    public function subcategory_wise_product_show(int $id, string $name)
    {
        $latestProducts = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();

        $categories = Category::with('subcategories')
            ->select('id', 'name')
            ->where('status', 1)
            ->latest()
            ->get();

        $subcategory_wise_products = Subcategory::with(
            'products.images',
            'products.price',
            'category'
        )->findOrFail($id);

        $brand_names = Product::whereNotNull('brand')
            ->where('brand', '!=', '')
            ->selectRaw('TRIM(LOWER(brand)) as brand')
            ->distinct()
            ->orderBy('brand', 'asc')
            ->pluck('brand');

        $brand_products = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->orderBy('brand', 'asc')
            ->latest()
            ->limit(16)
            ->get()
            ->groupBy('brand');

        return view('frontend.subcategory_wise_product', compact('latestProducts', 'subcategory_wise_products', 'categories', 'brand_names', 'brand_products'));
    }

    public function brand_wise_product_show(string $name)
    {
        $latestProducts = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();

        // $categories = Category::with('subcategories.products.images', 'subcategories.products.price')
        //     ->where('status', 1)
        //     ->latest()
        //     ->get();
        $categories = Category::with('subcategories')
            ->select('id', 'name')
            ->where('status', 1)
            ->latest()
            ->get();

        $brand_names = Product::whereNotNull('brand')
            ->where('brand', '!=', '')
            ->selectRaw('TRIM(LOWER(brand)) as brand')
            ->distinct()
            ->orderBy('brand', 'asc')
            ->pluck('brand');

        $brand_wise_products = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->whereRaw('LOWER(TRIM(brand)) = ?', [Str::lower(trim($name))])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.brand_wise_product', compact('latestProducts', 'categories', 'brand_names', 'brand_wise_products'));
    }



    //  public function category_wise_view_all_product()
    // {
    //     $latestProducts = Product::with(['images', 'price', 'subcategory.category'])
    //         ->where('status', 1)
    //         ->latest()
    //         ->limit(16)
    //         ->get();

    //     $categories = Category::with('subcategories')
    //         ->select('id', 'name')
    //         ->where('status', 1)
    //         ->latest()
    //         ->get();

    //     $category_products = Category::with('subcategories.products.images', 'subcategories.products.price')
    //         ->where('status', 1)
    //         ->latest()
    //         ->get();

    //     $brand_names = Product::whereNotNull('brand')
    //         ->where('brand', '!=', '')
    //         ->selectRaw('TRIM(LOWER(brand)) as brand')
    //         ->distinct()
    //         ->orderBy('brand', 'asc')
    //         ->pluck('brand');

    //     $brand_products = Product::with(['images', 'price', 'subcategory.category'])
    //         ->where('status', 1)
    //         ->orderBy('brand', 'asc')
    //         ->latest()
    //         ->limit(16)
    //         ->get()
    //         ->groupBy('brand');






    //     $categoryId = null;
    //     $products = Product::with([
    //         'images',
    //         'price',
    //         'subcategory.category'
    //     ])
    //         ->where('status', 1);
    //     if ($categoryId) {

    //         $products->whereHas('subcategory', function ($query) use ($categoryId) {

    //             $query->where('category_id', $categoryId);
    //         });
    //     }
    //     $products = $products->latest()->paginate(4);

    //     return view('homepage.index', compact('latestProducts', 'categories', 'category_products', 'brand_names', 'brand_products', 'categoryId', 'products'));
    // }








    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
