<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class LiveSearchController extends Controller
{

    // all register live search start here
    public function allRegisterSearch(Request $request)
    {
        $searchValue = $request->registersearch;

        $all_register = User::where('name', 'like', "%$searchValue%")
            ->orWhere('phone', 'like', "%$searchValue%")
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
            ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'productSearchStatus' => 'success',
                'productSearchProperty' => view('admin.products.search.product_table', compact('allProducts'))->render(),
            ]);
        }
    }
    // product live search end here













}
