<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductModel;
use App\Models\Size;
use App\Models\Product;

class LiveSearchController extends Controller
{

    // all register live search start here
    public function allRegisterSearch(Request $request)
    {
        $searchValue = $request->registersearch;

        $all_register = User::where('name', 'like', "%$searchValue%")
            ->orWhere('phone', 'like', "%$searchValue%")
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'registerSearchStatus' => 'success',
                'registerSearchProperty' => view(
                    'admin.all_register_info.search.all_register_table',
                    compact('all_register')
                )->render(),
            ]);
        }
        return redirect()->back();
    }
    // all register live search end here


    //admin live search start here
    public function adminSearch(Request $request)
    {
        $search = $request->admin_search;

        $admin_details = User::where('role', 'admin')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'adminSearchStatus' => 'success',
                'adminSearchProperty' => view(
                    'admin.details.search.admin_table',
                    compact('admin_details')
                )->render(),
            ]);
        }
    }
    //admin live search end here

    //vendor live search start here
    public function vendorSearch(Request $request)
    {
        $vendor_search = $request->vendor_search;

        $vendor_details = User::where('role', 'vendor')
            ->where(function ($query) use ($vendor_search) {
                $query->where('name', 'like', "%$vendor_search%")
                    ->orWhere('phone', 'like', "%$vendor_search%");
            })
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'vendorSearchStatus' => 'success',
                'vendorSearchProperty' => view('admin.all_vendor.search.vendor_table', compact('vendor_details'))->render(),
            ]);
        }
        return redirect()->back();
    }
    //vendor live search end here

    //user live search start here
    public function userSearch(Request $request)
    {
        $user_search = $request->user_search;

        $user_details = User::where('role', 'user')
            ->where(function ($query) use ($user_search) {
                $query->where('name', 'like', "%$user_search%")
                    ->orWhere('phone', 'like', "%$user_search%");
            })
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'userSearchStatus' => 'success',
                'userSearchProperty' => view('admin.all_user.search.user_table', compact('user_details'))->render(),
            ]);
        }
        return redirect()->back();
    }
    //user live search end here

    // category live search start here
    public function categorySearch(Request $request)
    {
        $categorysearch = $request->categorysearch;

        $allCategories = Category::where('id', 'like', "%$categorysearch%")
            ->orWhere('name', 'like', "%$categorysearch%")
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'categorySearchStatus' => 'success',
                'categorySearchProperty' => view('admin.categories.search.category_table', compact('allCategories'))->render(),
            ]);
        }
    }
    // category live search end here

    // subcategory live search start here
    public function subcategorySearch(Request $request)
    {
        $subCategorysearch = $request->subCategorysearch;

        $allSubcategories = Subcategory::where('id', 'like', '%' . $subCategorysearch . '%')
            ->orWhere('subcategory_name', 'like', '%' . $subCategorysearch . '%')
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'subCategorySearchStatus' => 'success',
                'subCategorySearchProperty' => view('admin.sub_categories.search.sub_category_table', compact('allSubcategories'))->render(),
            ]);
        }
    }
    // subcategory live search end here

    // product live search start here
    public function productSearch(Request $request)
    {
        $productSearchData = $request->product_search; // product_search এটা field name না এটা হচ্ছে $request->key  data: { key: value }  AJAX য়ের key নাম

        $allProducts = Product::where('id', 'like', "%{$productSearchData}%")
            ->orWhere('name', 'like', "%{$productSearchData}%")
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'productSearchStatus' => 'success',
                'productSearchProperty' => view('admin.products.search.product_table', compact('allProducts'))->render(),
            ]);
        }
    }
    // product live search end here

    //banner live search start here
    public function bannerSearch(Request $request)
    {
        $bannerSearchData = $request->banner_search; // banner_search এটা request য়ের field name না এটা হচ্ছে AJAX য়ের key name.  data: { key: value }

        $allBanners = Banner::where('type', 'like', "%{$bannerSearchData}%")
            ->orWhere('id', $bannerSearchData)
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'bannerSearchStatus' => 'success',
                'bannerSearchProperty' => view('admin.banners.search.banner_table', compact('allBanners'))->render(),
            ]);
        }
    }
    //banner live search end here

    //brand live search start here
    public function brandSearch(Request $request)
    {
        $brandSearchData = $request->brand_search; // brand_search এটা field name না এটা হচ্ছে AJAX য়ের key name.  data: { key: value }

        $allBrands = Brand::where('id', 'like', "%{$brandSearchData}%")
            ->orWhere('name', 'like', "%{$brandSearchData}%")
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'brandSearchStatus' => 'success',
                'brandSearchProperty' => view('admin.brands.search.brand_table', compact('allBrands'))->render(),
            ]);
        }
    }
    //brand live search end here

    //color live search start here
    public function colorSearch(Request $request)
    {
        $colorSearchData = $request->color_search;  // color_search এটা field name না এটা হচ্ছে AJAX য়ের key name.  data: { key: value }
        $all_colors = Color::where('id', 'like', "%{$colorSearchData}%")
            ->orWhere('name', 'like', "%{$colorSearchData}%")
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'colorSearchStatus' => 'success',
                'colorSearchProperty' => view('admin.colors.search.color_table', compact('all_colors'))->render(),
            ]);
        }
    }
    //color live search end here

    //model live search start here
    public function modelSearch(Request $request)
    {
        $product_model_search_query = $request->product_model_search_query;  // color_search এটা field name না এটা হচ্ছে AJAX য়ের key name.  data: { key: value }
        $product_models = ProductModel::where('id', 'like', "%{$product_model_search_query}%")
            ->orWhere('name', 'like', "%{$product_model_search_query}%")
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'product_model_search_status' => 'success',
                'product_model_search_property' => view('admin.product_models.search.product_model_table', compact('product_models'))->render(),
            ]);
        }
    }
    //model live search end here

    //size live search start here
    public function sizeSearch(Request $request)
    {
        $sizeSearchData = $request->size_search; // size_search এটা field name না এটা হচ্ছে AJAX য়ের key name.  data: { key: value }

        $all_sizes = Size::where('id', 'like', "%{$sizeSearchData}%")
            ->orWhere('name', 'like', "%{$sizeSearchData}%")
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'sizeSearchStatus' => 'success',
                'sizeSearchProperty' => view('admin.sizes.search.size_table', compact('all_sizes'))->render(),
            ]);
        }
    }
    //size live search end here













}
