<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_count = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $vendorCount = User::where('role', 'vendor')->count();
        $userCount = User::where('role', 'user')->count();
        $categories_count = Category::count();
        $subcategories_count = Subcategory::count();
        $products_count = Product::count();

        $updated = [
            'admin'  => User::where('role', 'admin')->latest('updated_at')->first(),
            'vendor' => User::where('role', 'vendor')->latest('updated_at')->first(),
            'user'   => User::where('role', 'user')->latest('updated_at')->first(),
            'category' => Category::latest('updated_at')->first(),
            'subcategory' => Subcategory::latest('updated_at')->first(),
            'product' => Product::latest('updated_at')->first(),
        ];

        return view('admin.dashboard', compact(
            'total_count',
            'adminCount',
            'vendorCount',
            'userCount',
            'categories_count',
            'subcategories_count',
            'products_count',
            'updated'
        ));
    }
}
