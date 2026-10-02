<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $latestProducts = Product::with([
            'images',
            'variants',
            'subcategory.category'
        ])->latest()->take(8)->get();

        $category_products = Category::with([
            'subcategories.products.images',
            'subcategories.products.variants'
        ])->get();

        $subcategory_products = Subcategory::with([
            'products.images',
            'products.variants',
            'category'
        ])->get();

        return view('homepage.index', compact(
            'categories',
            'latestProducts',
            'category_products',
            'subcategory_products'
        ));
    }
}
