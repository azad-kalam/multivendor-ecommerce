<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class LiveSearchController extends Controller
{
    public function productSearch(Request $request)
    {
        $search = $request->search_data;

        $all_vendor_Products = Product::where('id', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'productSearchStatus' => 'success',
                'productSearchProperty' => view(
                    'vendor.products.search.product_table',
                    compact('all_vendor_Products')
                )->render(),
            ]);
        }

        // Optional: initial page load
        return view('vendor.products.index', compact('all_vendor_Products'));
    }
}
