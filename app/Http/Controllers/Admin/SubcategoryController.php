<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use PHPUnit\TextUI\XmlConfiguration\RemoveLogTypes;

use function Laravel\Prompts\alert;

class SubcategoryController extends Controller
{
    // index start here
    public function index()
    {
        $allcategoryIdName = Category::select(['id', 'name'])->get();
        $allSubcategories = Subcategory::paginate(5);
        $totalCountSubcategories = Subcategory::count();
        return view('admin.sub_categories.CRUD.index', compact('allcategoryIdName', 'allSubcategories', 'totalCountSubcategories'));
    }
    // index end here

    // store start here
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|string|max:60|unique:subcategories,subcategory_name',
            'subcategory_title' => 'nullable|string|max:100',
            'subcategory_description' => 'nullable|string|max:255',
            'subcategory_slug' => 'required|string|max:100|unique:subcategories,subcategory_slug',
            'subcategory_status' => 'required|in:active,inactive',
        ]);
        $baseSlug = Str::slug($request->subcategory_slug);
        $uniqueSlug = $baseSlug . '-' . uniqid();

        $subcategoryCreate = new Subcategory();
        $subcategoryCreate->category_id = $request->category_id;
        $subcategoryCreate->subcategory_name = $request->subcategory_name;
        $subcategoryCreate->subcategory_title = $request->subcategory_title;
        $subcategoryCreate->subcategory_description = $request->subcategory_description;
        $subcategoryCreate->subcategory_status = $request->subcategory_status;
        $subcategoryCreate->subcategory_slug = $uniqueSlug;
        $subcategoryCreate->save();

        $totalSubcategories = Subcategory::count();
        $lastPagination = ceil($totalSubcategories / 5);
        return response()->json([
            'subcategoryCreateStatus' => 'success',
            'SubCategoryLastPagination' => $lastPagination,
            'redirectSubcategoryURL' => route('admin.sub_categories.CRUD.index')
        ]);
    }
    // store end here

    // show start here
    public function show($id)
    {
        $subCategoryDetails = Subcategory::with('category')->findOrFail($id);
        return response()->json([
            'subCategoryDetails' => $subCategoryDetails,
            'subCategoryShowStatus' => 'success',
            'redirect' => route('admin.sub_categories.CRUD.index')
        ]);
    }
    // show end here

    // edit start here
    public function edit($id)
    {
        $subCategoryDetails = Subcategory::findOrFail($id);
        $categories = Category::select(['id', 'name'])->get();
        return response()->json([
            'subCategoryDetails' => $subCategoryDetails,
            'categories' => $categories,
            'subCategoryEditStatus' => 'success',
        ]);
    }
    // edit end here

    // update start her
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|string|max:60|unique:subcategories,subcategory_name,' . $id,
            'subcategory_title' => 'nullable|string|max:100',
            'subcategory_description' => 'nullable|string|max:255',
            'subcategory_status' => 'required|in:active,inactive',
            'subcategory_slug' => 'required|string|max:100|unique:subcategories,subcategory_slug,' . $id,
        ]);

        $subcategoryUpdate = Subcategory::findOrFail($id);

        $baseSlug = Str::slug($request->subcategory_slug);
        $last13Chars = substr($baseSlug, -13);
        $beforeValue = Str::beforeLast($baseSlug, '-');
        $afterValue = Str::afterLast($baseSlug, '-');

        if (Str::contains($baseSlug, '-')) {
            if (!empty($beforeValue) && !empty($afterValue) && $last13Chars === $afterValue) {
                $uniqueSlug = Str::slug($beforeValue) . '-' . Str::slug($afterValue);
            } elseif (!empty($beforeValue) && !empty($afterValue) && $last13Chars !== $afterValue) {
                $uniqueSlug = Str::slug($beforeValue) . '-' . Str::slug($afterValue) . '-' . uniqid();
            } elseif ($beforeValue && $afterValue == null) {
                $slug = Str::slug($beforeValue);
                $uniqueSlug = $slug . '-' . uniqid();
            } elseif (!$beforeValue && $afterValue) {
                $slug = Str::slug($request->subcategory_name);
                $uniqueSlug = $slug . '-' . $afterValue;
            } else {
                $slug = Str::slug($request->subcategory_name);
                $uniqueSlug = $slug . '-' . uniqid();
            }
        } else {
            $slug = Str::slug($request->subcategory_name);
            $uniqueSlug = $slug . '-' . uniqid();
        }

        $subcategoryUpdate->category_id = $request->category_id;
        $subcategoryUpdate->subcategory_name = $request->subcategory_name;
        $subcategoryUpdate->subcategory_title = $request->subcategory_title;
        $subcategoryUpdate->subcategory_description = $request->subcategory_description;
        $subcategoryUpdate->subcategory_status = $request->subcategory_status;
        $subcategoryUpdate->subcategory_slug = $uniqueSlug;
        $subcategoryUpdate->save();

        return response()->json([
            'subcategoryUpdateStatus' => 'success',
            'redirect' => route('admin.sub_categories.CRUD.index')
        ]);
    }
    // update end here

    // delete start here
    public function destroy(string $id)
    {
        $subcategoryDelete = Subcategory::findOrFail($id);
        $subcategoryDelete->delete();
        return response()->json([
            'subcategoryDeleteStatus' => 'success',
            'redirect' => route('admin.sub_categories.CRUD.index')
        ]);
    }
    // delete end here
}
