<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;


class HomeController extends Controller
{
    // latest products start here
    public function index()
    {
        $categories = Category::with('subcategories')->get();
        $products = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();
        return view('homepage.index', compact('categories', 'products'));
    }
    // latest products end here


    // category wise product show start here
    public function category_wise_product_show($id)
    {
        $categories = Category::with('subcategories')->get();

        $products = Product::with(['images', 'price', 'subcategory.category'])
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();

        $category = Category::with(['subcategories.firstProduct.images', 'subcategories.firstProduct.price'])
            ->findOrFail($id);

        return view('homepage.index', compact('categories', 'products', 'category'));
    }
    // category wise product show end here





}
