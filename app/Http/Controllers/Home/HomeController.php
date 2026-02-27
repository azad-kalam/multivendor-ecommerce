<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
     public function index()
    {
        $categories = Category::with('subcategories')->get();
        $products = Product::with('images')
            ->where('status', 1)
            ->latest()
            ->limit(16)
            ->get();
        return view('homepage.index', compact('categories', 'products'));
    }
}
