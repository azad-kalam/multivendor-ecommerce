<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // index start here
    public function index()
    {
        $allCategories = Category::paginate(5);
        return view('admin.categories.CRUD.index', compact('allCategories'));
    }
    // index end here

    // store start here
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60|unique:categories,name',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'slug' => 'nullable|string|max:100|unique:categories,slug',
        ]);
        if ($request->name === $request->slug) {
            $baseSlug = Str::slug($request->name);
        } else {
            $baseSlug = Str::slug($request->slug);
        }
        // Always append unique 8-character suffix
        $uniqueSlug = $baseSlug . '-' . Str::random(8);
        //Check this slug already exists into database
        while (Category::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $baseSlug . '-' . Str::random(8);
        }

        Category::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'slug' => $uniqueSlug,
        ]);

        $totalCategories = Category::count();
        $lastPage = ceil($totalCategories / 5);
        return response()->json([
            'categoryCreateStatus' => 'success',
            'CategoryLastPagination' => $lastPage,
            'redirectCategoryURL' => route('admin.categories.CRUD.index'),
        ]);
    }
    // store end here
    // show start here
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'categoryDetails' => $category,
            'categoryShowStatus' => 'success',
            'redirect' => route('admin.categories.CRUD.index')
        ]);
    }
    // show end here

    // edit start here
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'categoryEditStatus' => 'success',
            'categoryEditDetails' => $category
        ]);
    }
    // edit end here

    // update start here
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:60|unique:categories,name,' . $category->id,
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'slug' => 'nullable|string|max:100|unique:categories,slug,' . $category->id,
        ]);
        if ($request->name !== $category->name) {
            $baseSlug = Str::slug($request->name);
        } elseif ($request->slug !== $category->slug) {
            $baseSlug = Str::slug($request->slug);
        } else {
            $baseSlug = Str::slug($category->slug);
        }
        // Ensure slug ends with -random(6) only if not already present
        if (!preg_match('/-[a-f0-9]{8}$/', $baseSlug)) {
            $baseSlug .= '-' . substr(uniqid(), 0, 8);
        }
        $validatedData['slug'] = $baseSlug;

        $category->update($validatedData);

        // Accurate pagination page (based on position, not ID)
        $index = Category::where('id', '<=', $category->id)->count();
        $page = ceil($index / 5);

        return response()->json([
            'categoryUpdateStatus' => 'success',
            'CategoryCurrentPage' => $page,
            'redirectCategoryupdatepage' => route('admin.categories.CRUD.index')
        ]);
    }
    // update end here
    // delete start here
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'categoryDeleteStatus' => 'success',
            'redirect' => route('admin.categories.CRUD.index')
        ]);
    }
    // delete end here
}
