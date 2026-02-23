<?php

namespace App\Http\Controllers\Vendor;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'vendor') {
            $vendor_info = Auth::user(); //current logged in info get

            $vendor_name = $vendor_info->name;
            $vendor_last_updated = $vendor_info->updated_at;

            $vendor_products_total_count = Product::where('user_id', $vendor_info->id)->count();

            $vendor_product_last_updated = Product::where('user_id', $vendor_info->id)
                ->latest('updated_at')
                ->first();

            return view('vendor.dashboard', compact(
                'vendor_name',
                'vendor_last_updated',
                'vendor_products_total_count',
                'vendor_product_last_updated'
            ));
        } else {
            abort(403, 'Unauthorized'); // or redirect to login/home
        }
    }
}
