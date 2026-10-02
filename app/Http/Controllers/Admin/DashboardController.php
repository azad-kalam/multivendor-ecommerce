<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Color;
use App\Models\ProductModel;
use App\Models\User;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_count = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $vendorCount = User::where('role', 'vendor')->count();
        $userCount = User::where('role', 'user')->count();
        $banners_count = Banner::count();
        $brands_count = Brand::count();
        $categories_count = Category::count();
        $subcategories_count = Subcategory::count();
        $colors_count = Color::count();
        $product_models_count = ProductModel::count();
        $products_count = Product::count();
        $sizes_count = Size::count();

        $updated = [
            'admin'  => User::where('role', 'admin')->latest('updated_at')->first(),
            'vendor' => User::where('role', 'vendor')->latest('updated_at')->first(),
            'user'   => User::where('role', 'user')->latest('updated_at')->first(),
            'banner' => Banner::latest('updated_at')->first(),
            'brand' => Brand::latest('updated_at')->first(),
            'category' => Category::latest('updated_at')->first(),
            'subcategory' => Subcategory::latest('updated_at')->first(),
            'color' => Color::latest('updated_at')->first(),
            'product_model' => ProductModel::latest('updated_at')->first(),
            'product' => Product::latest('updated_at')->first(),
            'size' => Size::latest('updated_at')->first(),
        ];

        return view('admin.dashboard', compact(
            'total_count',
            'adminCount',
            'vendorCount',
            'userCount',
            'banners_count',
            'brands_count',
            'categories_count',
            'subcategories_count',
            'colors_count',
            'product_models_count',
            'products_count',
            'sizes_count',
            'updated'
        ));
    }
}
