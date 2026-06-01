<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class HomeController extends Controller
{
    // public function index()
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

    //     return view('homepage.index', compact('latestProducts', 'categories', 'category_products', 'brand_names', 'brand_products'));
    // }









    public function index()
    {
        $latestProducts = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();

        $categories = Category::with([
            'subcategories:id,category_id,subcategory_name'
        ])
            ->select('id', 'name')
            ->where('status', 'active')
            ->latest()
            ->get();

        $category_products = Category::with([
            'subcategories.products.images',
            'subcategories.products.price'
        ])
            ->where('status', 'active')
            ->whereHas('subcategories', function ($query) {
                $query->where('subcategory_status', 'active')
                    ->whereHas('products', function ($q) {
                        $q->where('status', 1);
                    });
            })
            ->latest()
            ->get();


        $subcategory_products = Subcategory::with([
            'category',
            'products.images',
            'products.price'
        ])
            ->where('subcategory_status', 'active')
            ->whereHas('category', function ($q) {
                $q->where('status', 'active');
            })
            ->whereHas('products', function ($q) {
                $q->where('status', 1);
            })
            ->latest()
            ->get();

        $brand_names = Product::whereNotNull('brand')
            ->where('brand', '!=', '')
            ->selectRaw('TRIM(LOWER(brand)) as brand')
            ->distinct()
            ->orderBy('brand', 'asc')
            ->pluck('brand');

        $brand_products = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->whereNotNull('brand')
            ->whereHas('subcategory', function ($q) {
                $q->where('subcategory_status', 'active')
                    ->whereHas('category', function ($q2) {
                        $q2->where('status', 'active');
                    });
            })
            ->latest()
            ->get();

        return view('homepage.index', compact(
            'latestProducts',
            'categories',
            'category_products',
            'subcategory_products',
            'brand_names',
            'brand_products'
        ));
    }
}
