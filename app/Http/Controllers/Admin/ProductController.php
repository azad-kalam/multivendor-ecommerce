<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Price;
use App\Models\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $catWithSubcat = Category::select(['id', 'name'])->with(['subcategories:id,category_id,subcategory_name'])->get();
        $allProducts = Product::paginate(5);

        return view('admin.products.CRUD.index', compact('catWithSubcat', 'allProducts'));
    }


    public function create(Request $request)
    {
        $categorieIdName = Category::select(['id', 'name'])->get();
        return view('admin.products.CRUD.create', compact('categorieIdName'));
    }

    public function dependentCategoryID($category_id)
    {
        $subcategories = Subcategory::select(['id', 'subcategory_name'])->where('category_id', $category_id)->get();
        return response()->json([
            $category_id,
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
        if ($user && $user->role == 'admin' && $user->status == 1) { // admin login আছে এবং active

            if (!empty($request->slug)) {
                $validated['slug'] = $request->slug;
            } else {
                $validated['slug'] = Str::slug($request->name) . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 11);
            }

            // Initialize duplicate count
            $duplicateCount = 0;

            // Check for image duplicates
            if ($request->hasFile('image')) {
                $uploaded = $request->file('image');
                $uploadedHashes = [];

                foreach ($uploaded as $image) {
                    $hash = md5_file($image->getRealPath());
                    $hasExists = Image::where('file_hash', $hash)->exists(); // Check if hash already exists in DB


                    if ($hasExists) {
                        $duplicateCount++;
                        continue; // Skip the image if duplicate
                    }

                    // Store the hash of the uploaded image for future checks
                    $uploadedHashes[] = $hash;
                }

                // If there are duplicates, show a warning and stop the process
                if ($duplicateCount > 0) {
                    session()->flash('toastr_error', "{$duplicateCount} File(s) already exist. Data not saved.");
                    return redirect()->back()->withInput(); // Go back with input to show the form again
                }
            }

            // Save the product (without images initially)
            $product = Product::create(Arr::except($validated, ['image']));

            $publicFolder = public_path('uploads/images/');
            $dbPath = 'uploads/images/';

            if (!File::exists($publicFolder)) {
                File::makeDirectory($publicFolder, 0755, true);
            }

            // Save images if no duplicates
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $hash = md5_file($image->getRealPath()); // Get hash for the uploaded image
                    $originalName = $image->getClientOriginalName();
                    $ext = $image->getClientOriginalExtension();
                    $uniqueName = time() . '_' . uniqid() . '.' . $ext;

                    $manager = new ImageManager(new Driver());
                    $img = $manager->read($image->getRealPath());
                    $img->scaleDown(800, 800);
                    $img->save($publicFolder . $uniqueName, quality: 80);

                    // Move the image to the public directory
                    // $image->move($publicFolder, $uniqueName);

                    // Save image records into database
                    $product->images()->create([
                        'file_name' => $originalName,
                        'public_path' => $dbPath . $uniqueName,
                        'file_hash' => $hash,
                        'alt_text' => $product->name,
                        'video_url' => $validated['video_url'] ?? null,
                    ]);
                }
            }

            // Save product pricing details
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

    public function show($id)
    {
        $productDetails = Product::findOrFail($id);
        return view('admin.products.CRUD.show', compact('productDetails'));
    }


    public function edit($id)
    {
        $productFind = Product::findOrFail($id);
        return view('admin.products.CRUD.edit', compact('productFind'));
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
        if ($user && $user->role == 'admin' && $user->status == 1) {

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
                $redirect = $redirect->with('toastr_warning', "{$duplicateCount} file(s) already exist. Data not saved.");
            }

            return $redirect;
        } else {
            return back()->with('toastr_error', 'Your account is temporarily blocked. Data not updated !');
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();
        if ($user && $user->role == 'admin' && $user->status == 1) {
            $product->delete();
            return redirect()->route('admin.products.CRUD.index')->with('toastr_success', 'Product deleted successfully !');
        } else {
            return back()->with('toastr_error', 'Your account is temporarily blocked. Data not deleted !');
        }

    }

    public function status(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->status == 1) {
            $product->update(['status' => 0]);
            $message = 'Product deactivated successfully !';
        } else {
            $product->status == 0;
            $product->update(['status' => 1]);
            $message = 'Product activated successfully !';
        }
        $product->save();
        return back()->with('toastr_success', $message);
    }
}
