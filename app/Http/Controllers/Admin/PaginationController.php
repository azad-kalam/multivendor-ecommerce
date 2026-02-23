<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use App\Models\User;

class PaginationController extends Controller
{
    // category pagination start here
    public function categoryPagination(Request $request)
    {
        $allCategories = Category::paginate(5);
        return response()->json([
            'categoryPaginationStatus' => 'success',
            'categoriesPaginationProperty' => view('admin.categories.pagination.category_table', compact('allCategories'))->render(),
        ]);
    }
    // category pagination end here

    // subcategory pagination start here
    public function subcategoryPagination(Request $request)
    {
        $allSubcategories = Subcategory::with('category')->paginate(5);
        return response()->json([
            'subCategoryPaginationStatus' => 'success',
            'allSubcategories' => $allSubcategories,
            'html' => view('admin.sub_categories.pagination.sub_category_table', compact('allSubcategories'))->render(),
        ]);
    }
    // subcategory pagination end here


}
