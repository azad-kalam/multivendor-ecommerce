<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $catWithSubcat = Category::select(['id', 'name'])
            ->with(['subcategories:id,category_id,subcategory_name'])
            ->get();

        $productsQuery = Product::with([
            'images',
            'price',
            'subcategory.category'
        ]);
        $user = Auth::user();
        $productsQuery->where('user_id', $user->id);
        $all_vendor_Products = $productsQuery->paginate(5);

        if ($user && $user->role === 'vendor') {
            return view('vendor.products.index', compact(
                'catWithSubcat',
                'all_vendor_Products'
            ));
        } else {
            return back()->with('toastr_error', 'Unauthorized access.');
        }
    }


    public function create()
    {
        $categorieIdName = Category::select(['id', 'name'])->get();
        return view('vendor.products.create', compact('categorieIdName'));
    }

    public function dependencyCategoryID($category_id)
    {
        $subcategories = Subcategory::select(['id', 'subcategory_name'])->where('category_id', $category_id)->get();

        if ($subcategories->isEmpty()) {
            return response()->json([
                'categoryDependentIDStatus' => 'empty',
                'message' => 'subcategories no available.',
                'subcategories' => []
            ]);
        }

        return response()->json([
            'categoryDependentIDStatus' => 'success',
            'subcategories' => $subcategories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'full_description' => 'nullable|string|max:300',
            'short_description' => 'nullable|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock',
            'manage_stock' => 'nullable|boolean',
            'status' => 'required|in:0,1',
            'visibility' => 'required|in:visible,hidden',
            'featured' => 'nullable|boolean',
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'video_url' => 'nullable|url',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'product_weight' => 'nullable|numeric|min:0|max:999.999',
            'warranty' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'regular_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_type' => 'required|in:none,flat,percent',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
        ]);

        $validated['user_id'] = Auth::id();
        $user = Auth::user();
        if ($user->role == 'vendor' && $user->status == 1) {

            if (!empty($request->slug)) {
                $validated['slug'] = $request->slug;
            } else {
                $validated['slug'] = Str::slug($request->name) . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 11);
            }

            $duplicateCount = 0;

            if ($request->hasFile('image')) {
                $uploaded = $request->file('image');
                $uploadedHashes = [];

                foreach ($uploaded as $image) {
                    $hash = md5_file($image->getRealPath());
                    $hasExists = Image::where('file_hash', $hash)->exists();

                    if ($hasExists) {
                        $duplicateCount++;
                        continue;
                    }

                    $uploadedHashes[] = $hash;
                }

                if ($duplicateCount > 0) {
                    session()->flash('toastr_error', "{$duplicateCount} File (s) already exist. Data not saved.");
                    return redirect()->back()->withInput();
                }
            }

            $product = Product::create(Arr::except($validated, ['image']));

            $publicFolder = public_path('uploads/images/');
            $dbPath = 'uploads/images/';

            if (!File::exists($publicFolder)) {
                File::makeDirectory($publicFolder, 0755, true);
            }

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $hash = md5_file($image->getRealPath());
                    $originalName = $image->getClientOriginalName();
                    $ext = $image->getClientOriginalExtension();
                    $uniqueName = time() . '_' . uniqid() . '.' . $ext;

                    $manager = new ImageManager(new Driver());
                    $img = $manager->read($image->getRealPath());
                    $img->scaleDown(800, 800);
                    $img->save($publicFolder . $uniqueName, quality: 80);

                    $product->images()->create([
                        'file_name' => $originalName,
                        'public_path' => $dbPath . $uniqueName,
                        'file_hash' => $hash,
                        'alt_text' => $product->name,
                        'video_url' => $validated['video_url'] ?? null,
                    ]);
                }
            }

            $product->price()->create([
                'regular_price' => $validated['regular_price'],
                'selling_price' => $validated['selling_price'],
                'discount_value' => $validated['discount_value'] ?? 0,
                'discount_type' => $validated['discount_type'],
                'discount_start' => $validated['discount_start'] ?? null,
                'discount_end' => $validated['discount_end'] ?? null,
            ]);

            return redirect()->route('homepage.index')
                ->with('toastr_success', 'Product created successfully !');
        } else {
            return back()->with('toastr_error', 'Your account is temporarily blocked. Data not saved !');
        }
    }

    public function show(string $id)
    {
        $productDetails = Product::with('images')->findOrFail($id);
        return view('vendor.products.show', compact('productDetails'));
    }

    public function edit(string $id)
    {
        $productFind = Product::findOrFail($id);
        return view('vendor.products.edit', compact('productFind'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'full_description' => 'nullable|string|max:300',
            'short_description' => 'nullable|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock',
            'manage_stock' => 'nullable|boolean',
            'status' => 'required|in:0,1',
            'visibility' => 'required|in:visible,hidden',
            'featured' => 'nullable|boolean',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'video_url' => 'nullable|url',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'product_weight' => 'nullable|numeric|min:0|max:999.999',
            'warranty' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'regular_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_type' => 'required|in:none,flat,percent',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
        ]);
        $user = Auth::user();
        if ($user && $user->role == 'vendor' && $user->status == 1) {

            // slug
            $validated['slug'] = !empty($request->slug)
                ? $request->slug
                : Str::slug($request->name) . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 11);

            $product->update($validated);

            $publicFolder = public_path('uploads/images/');
            $dbPath = 'uploads/images/';
            if (!File::exists($publicFolder)) {
                File::makeDirectory($publicFolder, 0755, true);
            }

            $duplicateCount = 0;
            $savedCount = 0;

            if ($request->hasFile('image')) {
                $uploaded = $request->file('image');
                $uploadedHashes = [];
                $toUpload = [];
                foreach ($uploaded as $image) {
                    $hash = hash_file('md5', $image->getRealPath());
                    if (in_array($hash, $uploadedHashes, true)) {
                        $duplicateCount++;
                        continue;
                    }
                    $existsInProduct = $product->images()->where('file_hash', $hash)->exists();

                    if ($existsInProduct) {
                        $duplicateCount++;
                        continue;
                    }
                    $uploadedHashes[] = $hash;
                    $toUpload[] = [
                        'file' => $image,
                        'hash' => $hash,
                    ];
                }

                if (count($toUpload) > 0) {
                    foreach ($product->images as $existingImage) {
                        if (!empty($existingImage->public_path) && File::exists(public_path($existingImage->public_path))) {
                            File::delete(public_path($existingImage->public_path));
                        }
                        $existingImage->delete();
                    }

                    foreach ($toUpload as $item) {
                        $image = $item['file'];
                        $hash = $item['hash'];

                        $originalName = $image->getClientOriginalName();
                        $ext = $image->getClientOriginalExtension();
                        $uniqueName = time() . '_' . rand(1, 9) . '.' . $ext;

                        $image->move($publicFolder, $uniqueName);
                        $product->images()->create([
                            'file_name' => $originalName,
                            'public_path' => $dbPath . $uniqueName,
                            'file_hash' => $hash,
                            'alt_text' => $product->name,
                            'video_url' => $validated['video_url'] ?? null,
                        ]);

                        $savedCount++;
                    }
                }
            }
            $product->price()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'regular_price' => $validated['regular_price'],
                    'selling_price' => $validated['selling_price'],
                    'discount_value' => $validated['discount_value'] ?? 0,
                    'discount_type' => $validated['discount_type'],
                    'discount_start' => $validated['discount_start'] ?? null,
                    'discount_end' => $validated['discount_end'] ?? null,
                ]
            );
            $redirect = redirect()->route('homepage.index');

            if ($savedCount > 0) {
                $redirect = $redirect->with('toastr_success', 'Product updated successfully.');
            } else {
                if ($duplicateCount === 0) {
                    $redirect = $redirect->with('toastr_success', 'Product updated successfully.');
                }
            }

            if ($duplicateCount > 0) {
                $redirect = $redirect->with('toastr_warning', "{$duplicateCount} file (s) already exist. Data not saved.");
            }

            return $redirect;
        } else {
            return back()->with('toastr_error', 'Your account is temporarily blocked. Data not updated !');
        }
    }


    public function destroy(string $id)
    {

    }

    public function status(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->status == 1) {
            $product->status = 0;
            $message = 'Product inactive successfully !';
        } else {
            $product->status = 1;
            $message = 'Product active successfully !';
        }

        $product->save();
        return back()->with('toastr_success', $message);
    }
}
