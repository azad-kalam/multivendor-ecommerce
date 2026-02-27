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
    public function reletedProductsBySubcategory(int $id)
    {
        $product = Product::with(['images', 'price', 'subcategory'])
            ->findOrFail($id);// Get related products based on a subcategories id

        $relatedProducts = Product::with(['images', 'price', 'subcategory'])
            ->where('subcategory_id', $product->subcategory_id)
            ->where('id', '!=', $product->id)
            ->orderBy('created_at', 'desc') // newest first
            ->limit(12)
            ->get();

        return view('frontend.show', compact('product', 'relatedProducts'));
    }





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
