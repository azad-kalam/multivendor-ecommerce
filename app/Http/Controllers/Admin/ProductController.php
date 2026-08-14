<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Throwable;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductModel;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $catWithSubcat = Category::select(['id', 'name'])->with(['subcategories:id,category_id,subcategory_name'])->get();
    //     $allProducts = Product::paginate(5);

    //     return view('admin.products.CRUD.index', compact('catWithSubcat', 'allProducts'));
    // }

    public function index()
    {
        $allProducts = Product::with([
            'user',
            'brand',
            'productModel',
            'subcategory.category',
            'variants.color',
            'variants.size',
            'images'
        ])->latest()->paginate(10);

        return view('admin.products.CRUD.index', compact('allProducts'));
    }


    public function create(Request $request)
    {
        $brands = Brand::select('id', 'name')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $colors = Color::query()
            ->select('id', 'name', 'code')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $sizes = Size::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $categorieIdName = Category::select(['id', 'name'])->get();
        return view('admin.products.CRUD.create', compact('brands', 'colors', 'sizes', 'categorieIdName', 'sizes'));
    }


    public function dependentCategoryID(int $category_id)
    {
        $subcategories_data = Subcategory::where('category_id', $category_id)
            ->select('id', 'subcategory_name')
            ->get();

        return response()->json($subcategories_data);
    }

    public function dependent_getModelsByBrand(int $brand_id)
    {
        $models = ProductModel::where('brand_id', $brand_id)
            ->where('status', 1)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($models);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'full_description' => 'nullable|string|max:300',

            'sku.*' => 'nullable|string|max:100',
            'slug' => 'nullable|string|max:255|unique:products,slug',

            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',

            'brand_id' => 'nullable|exists:brands,id',
            'product_model_id' => 'nullable|integer|exists:product_models,id',
            'color_id' => 'nullable|array',
            'color_id.*' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|array',
            'size_id.*' => 'nullable|exists:sizes,id',

            'image' => 'required|array',
            'image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video_url' => 'nullable|url',

            'visibility' => 'required|in:visible,hidden',
            'status' => 'required|in:0,1',
            'featured' => 'nullable|boolean',

            'stock_quantity' => 'nullable|array',
            'stock_quantity.*' => 'nullable|integer|min:0',

            'stock_status' => 'nullable|array',
            'stock_status.*' => 'nullable|in:in_stock,out_of_stock',

            'manage_stock' => 'nullable|array',
            'manage_stock.*' => 'nullable|boolean',

            'regular_price' => 'required|array',
            'regular_price.*' => 'required|numeric|min:0',

            'selling_price' => 'nullable|array',
            'selling_price.*' => 'nullable|numeric|min:0',

            'discount_type' => 'nullable|array',
            'discount_type.*' => 'nullable|in:none,fixed,percent',

            'discount_value' => 'nullable|array',
            'discount_value.*' => 'nullable|numeric|min:0',

            'discount_start' => ['nullable', 'array'],
            'discount_start.*' => ['nullable', 'date'],

            'discount_end' => ['nullable', 'array'],
            'discount_end.*' => ['nullable', 'date'],


            'product_weight' => 'nullable|numeric|min:0|max:999.999',
            'warranty' => 'nullable|string|max:100',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $user = Auth::user();
        if ($user && $user->role == 'admin' && $user->status == 1) { // admin login আছে এবং active

            DB::beginTransaction();
            try {

                $validated['slug'] = sanitize_slug(
                    $request->slug ?: $validated['name']
                );

                $duplicateCount = 0;
                $uploadedHashes = [];
                $duplicateFileNames = [];
                $upload_folder = 'products';

                if ($request->hasFile('image')) {
                    $images = $request->file('image');
                    $images = is_array($images) ? $images : [$images];

                    foreach ($images as $image) {

                        $hash = md5_file($image->getRealPath());

                        $hash_exists = Image::where('upload_folder', $upload_folder)
                            ->where('file_hash', $hash)
                            ->first();

                        $inRequest = in_array($hash, $uploadedHashes, true);

                        if ($hash_exists || $inRequest) {

                            $duplicateCount++;

                            $duplicateFileNames[] = $image->getClientOriginalName();

                            continue;
                        }

                        $uploadedHashes[] = $hash;
                    }

                    if ($duplicateCount > 0) {
                        throw new Exception(
                            "{$duplicateCount} [ " . implode(', ', $duplicateFileNames) . " ] image already exists. Data not saved."
                        );
                    }
                }

                $colorIds = $validated['color_id'] ?? [];
                $sizeIds  = $validated['size_id'] ?? [];
                foreach ($colorIds as $index => $colorId) {

                    $sizeId = $sizeIds[$index] ?? null;

                    $productName = strtolower(trim($validated['name']));

                    $exists = ProductVariant::where('color_id', $colorId)
                        ->where('size_id', $sizeId)
                        ->whereHas('product', function ($q) use ($productName) {
                            $q->whereRaw('LOWER(name) = ?', [$productName]);
                        })
                        ->exists();

                    if ($exists) {

                        $color = Color::find($colorId);
                        $size  = Size::find($sizeId);

                        throw new Exception("Product name + color + size combination already exists. Data not saved.");
                    }
                }

                $brand = Brand::find($validated['brand_id'] ?? null);
                $colors = Color::whereIn('id', array_filter($colorIds))->get()->keyBy('id');
                $sizes  = Size::whereIn('id', array_filter($sizeIds))->get()->keyBy('id');

                $variantData = [];
                $allSkus = [];

                foreach ($colorIds as $index => $colorId) {

                    $sizeId = $sizeIds[$index] ?? null;

                    $color = $colors->get($colorId);
                    $size  = $sizes->get($sizeId);

                    $discountStart = null;
                    $discountEnd = null;

                    if (!empty($validated['discount_start'][$index])) {
                        $discountStart = Carbon::parse($validated['discount_start'][$index] ?? null);
                    }

                    if (!empty($validated['discount_end'][$index])) {
                        $discountEnd = Carbon::parse($validated['discount_end'][$index] ?? null);
                    }

                    if ($discountStart && $discountEnd && $discountEnd->lt($discountStart)) {

                        throw new Exception("Discount End must be after or equal to Discount Start. Data not saved.");
                    }


                    $productName = Str::upper(
                        Str::substr($validated['name'] ?? 'PDT', 0, 3)
                    );

                    $brandName = Str::upper(
                        Str::substr($brand?->name ?? 'BND', 0, 3)
                    );

                    $colorName = Str::upper(
                        Str::substr($color?->name ?? 'CLR', 0, 3)
                    );

                    $sizeName = Str::upper(
                        Str::substr($size?->name ?? 'SZE', 0, 3)
                    );

                    $oldSku = '';

                    $sku = sanitize_sku(
                        $validated['sku'][$index] ?? '',
                        $oldSku,
                        $productName,
                        $brandName,
                        $colorName,
                        $sizeName
                    );

                    if (in_array($sku, $allSkus, true)) {

                        throw new Exception("Duplicate SKU [ {$sku} ] found in request. Data not saved.");
                    }

                    $exists = ProductVariant::where('sku', $sku)->exists();

                    if ($exists) {

                        throw new Exception("[ {$sku} ] SKU already exists. Data not saved.");
                    }

                    $allSkus[] = $sku;

                    $manageStock = (int) ($validated['manage_stock'][$index] ?? 0) === 1;

                    $stockQuantity = (int) ($validated['stock_quantity'][$index] ?? 0);

                    if (!$manageStock || $stockQuantity <= 0) {
                        $stockStatus = 'out_of_stock';
                    } else {
                        $stockStatus = 'in_stock';
                    }

                    $regularPrice  = (float) ($validated['regular_price'][$index] ?? 0);
                    $sellingPrice  = (float) ($validated['selling_price'][$index] ?? $regularPrice);

                    $discountType  = $validated['discount_type'][$index] ?? 'none';
                    $discountValue = (float) ($validated['discount_value'][$index] ?? 0);

                    switch ($discountType) {

                        case 'fixed':

                            $sellingPrice = max(0, $regularPrice - $discountValue);

                            break;

                        case 'percent':

                            $sellingPrice = max(
                                0,
                                $regularPrice - (($regularPrice * $discountValue) / 100)
                            );

                            break;

                        case 'none':
                        default:
                            $sellingPrice = min($sellingPrice, $regularPrice);
                            break;
                    }

                    $sellingPrice = round($sellingPrice, 2);
                    $variantData[] = [
                        'color_id'       => $colorId,
                        'size_id'        => $sizeId,
                        'regular_price'  => $regularPrice,
                        'selling_price'  => $sellingPrice,
                        'discount_type'  => $discountType,
                        'discount_value' => $discountValue,
                        'discount_start' => $discountStart?->format('Y-m-d H:i:s'),
                        'discount_end'   => $discountEnd?->format('Y-m-d H:i:s'),
                        'sku'            => $sku,
                        'stock_quantity' => $stockQuantity,
                        'manage_stock'   => $manageStock,
                        'stock_status'   => $stockStatus,
                    ];
                }

                $product = Product::create([
                    'user_id' => $user->id,

                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'],
                    'brand_id' => $validated['brand_id'] ?? null,
                    'product_model_id' => $validated['product_model_id'] ?? null,

                    'name' => $validated['name'],
                    'short_description' => $validated['short_description'] ?? null,
                    'full_description' => $validated['full_description'] ?? null,

                    'slug' => $validated['slug'],
                    'status' => $validated['status'],
                    'visibility' => $validated['visibility'],
                    'featured' => $validated['featured'] ?? 0,

                    'product_weight' => $validated['product_weight'] ?? null,
                    'warranty' => $validated['warranty'] ?? null,

                    'meta_title' => $validated['meta_title'] ?? null,
                    'meta_description' => $validated['meta_description'] ?? null,
                    'meta_keywords' => $validated['meta_keywords'] ?? null,
                ]);

                $variants = $product->variants()->createMany($variantData);

                $publicFolder = public_path("uploads/$upload_folder/");
                $dbPath = "uploads/$upload_folder/";

                if (!File::exists($publicFolder)) {
                    File::makeDirectory($publicFolder, 0755, true);
                }

                $images = $request->file('image', []);

                foreach ($variants as $index => $variant) {

                    if (isset($images[$index])) {

                        $image = $images[$index];

                        $hash = md5_file($image->getRealPath());

                        $data = resize_image($image);

                        $originalName = $data['originalName'];

                        $uniqueName = $data['uniqueName'];

                        $filePath = $publicFolder . $uniqueName;

                        save_resize_image($data, $filePath);

                        $variant->images()->create([
                            'product_id' => $product->id,
                            'product_variant_id' => $variant->id,
                            'file_name' => $originalName,
                            'upload_folder' => $upload_folder,
                            'public_path' => $dbPath . $uniqueName,
                            'file_hash' => $hash,
                            'alt_text' => $product->name,
                            'video_url' => $validated['video_url'] ?? null,
                        ]);
                    }
                }



                // $publicFolder = public_path("uploads/$upload_folder/");
                // $dbPath = "uploads/$upload_folder/";

                // if (!File::exists($publicFolder)) {
                //     File::makeDirectory($publicFolder, 0755, true);
                // }

                // if ($request->hasFile('image')) {
                //     $images = $request->file('image');
                //     $images = is_array($images) ? $images : [$images];

                //     foreach ($images as $image) {
                //         $hash = md5_file($image->getRealPath());

                //         $data = resize_image($image);
                //         $originalName = $data['originalName'];
                //         $uniqueName = $data['uniqueName'];
                //         $filePath = $publicFolder . $uniqueName;

                //         save_resize_image($data, $filePath);

                //         $product->images()->create([
                //             'file_name' => $originalName,
                //             'upload_folder' => $upload_folder,
                //             'public_path' => $dbPath . $uniqueName,
                //             'file_hash' => $hash,
                //             'alt_text' => $product->name,
                //             'video_url' => $validated['video_url'] ?? null,
                //         ]);
                //     }
                // }
                // $product->variants()->createMany($variantData);


                DB::commit();

                return redirect()->route('homepage.index')
                    ->with('toastr_success', 'Product created successfully !');
            } catch (\Exception $exception_error) {
                DB::rollBack();
                return back()
                    ->withInput()
                    ->with('toastr_error', $exception_error->getMessage());
            }
        } else {
            return back()->with('toastr_error', 'Your account is temporarily blocked. Data not saved !');
        }
    }

    // public function show(int $id)
    // {
    //     $productDetails = Product::findOrFail($id);
    //     return view('admin.products.CRUD.show', compact('productDetails'));
    // }

    public function show(int $id)
    {
        $productDetails = Product::with([
            'user',
            'category',
            'subcategory.category',
            'brand',
            'productModel',
            'images',
            'variants.color',
            'variants.size',
        ])->findOrFail($id);

        return view('admin.products.CRUD.show', compact('productDetails'));
    }


    // public function edit(int $id)
    // {
    //     $productFind = Product::findOrFail($id);
    //     $categories = Category::select('id', 'name')->get();

    //     $subcategories = Subcategory::where('category_id', $productFind->subcategory->category_id)
    //         ->select('id', 'subcategory_name')->get();

    //     return view('admin.products.CRUD.edit', compact('productFind', 'categories', 'subcategories'));
    // }

    public function edit(int $id)
    {
        $productFind = Product::with([
            'images',
            'variants.color',
            'variants.size'
        ])->findOrFail($id);

        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();

        $product_models = ProductModel::where('brand_id', $productFind->brand_id)
            ->where('status', 1)
            ->get();

        $categories = Category::all();

        $subcategories = Subcategory::where(
            'category_id',
            $productFind->category_id
        )->get();

        $skus = $productFind->variants->pluck('sku')->unique();

        return view('admin.products.CRUD.edit', compact(
            'productFind',
            'brands',
            'colors',
            'sizes',
            'skus',
            'product_models',
            'categories',
            'subcategories'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'full_description' => 'nullable|string|max:300',

            'variant_id' => 'nullable|array',
            'variant_id.*' => 'nullable|exists:product_variants,id',

            'sku' => 'nullable|array',
            'sku.*' => ['nullable', 'string', 'max:100'],

            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,

            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',

            'brand_id' => 'nullable|exists:brands,id',
            'product_model_id' => 'nullable|integer|exists:product_models,id',

            'color_id' => 'nullable|array',
            'color_id.*' => 'nullable|exists:colors,id',

            'size_id' => 'nullable|array',
            'size_id.*' => 'nullable|exists:sizes,id',

            'regular_price' => 'required|array',
            'regular_price.*' => 'required|numeric|min:0',

            'selling_price' => 'nullable|array',
            'selling_price.*' => 'nullable|numeric|min:0',

            'discount_type' => 'nullable|array',
            'discount_type.*' => 'nullable|in:none,fixed,percent',

            'discount_value' => 'nullable|array',
            'discount_value.*' => 'nullable|numeric|min:0',

            'discount_start' => 'nullable|array',
            'discount_start.*' => 'nullable|date',

            'discount_end' => 'nullable|array',
            'discount_end.*' => 'nullable|date',

            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'video_url' => 'nullable|url',

            'visibility' => 'required|in:visible,hidden',
            'status' => 'required|in:0,1',
            'featured' => 'nullable|boolean',

            'stock_quantity' => 'nullable|array',
            'stock_quantity.*' => 'nullable|integer|min:0',

            'stock_status' => 'required|array',
            'stock_status.*' => 'required|in:in_stock,out_of_stock',

            'manage_stock' => 'nullable|array',
            'manage_stock.*' => 'nullable|boolean',

            'product_weight' => 'nullable|numeric|min:0|max:999.999',
            'warranty' => 'nullable|string|max:100',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        if ($user && $user->role == 'admin' && $user->status == 1) {

            DB::beginTransaction();
            try {

                $slug = sanitize_slug(
                    $request->slug ?: $validated['name']
                );

                $baseSlug = $slug;
                $counter = 1;

                while (
                    Product::where('slug', $slug)
                    ->where('id', '!=', $product->id)
                    ->exists()
                ) {

                    $slug = $baseSlug . '-' . $counter++;
                }

                $validated['slug'] = $slug;

                $oldImages = collect();

                $toUpload = [];

                if ($request->hasFile('image')) {

                    foreach ($request->file('image') as $file) {

                        $toUpload[] = [
                            'file' => $file,
                            'hash' => hash_file('sha256', $file->getRealPath()),
                        ];
                    }
                }
                if (!empty($toUpload)) {
                    $oldImages = $product->images()->get();
                }

                if (!$product->update([
                    'user_id' => $user->id,
                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'],
                    'brand_id' => $validated['brand_id'] ?? null,
                    'product_model_id' => $validated['product_model_id'] ?? null,
                    'name' => $validated['name'],
                    'short_description' => $validated['short_description'] ?? null,
                    'full_description' => $validated['full_description'] ?? null,
                    'slug' => $validated['slug'],
                    'visibility' => $validated['visibility'],
                    'status' => $validated['status'],
                    'featured' => $validated['featured'] ?? 0,
                ])) {
                    throw new Exception('Failed to update product. Data not updated.');
                }

                if (!empty($toUpload)) {

                    $oldImages = $product->images()->get();

                    $folder = 'products';
                    $publicFolder = public_path("uploads/$folder/");
                    $dbPath = "uploads/$folder/";

                    if (!File::exists($publicFolder)) {
                        File::makeDirectory($publicFolder, 0755, true);
                    }

                    $newImages = [];

                    // Upload new images first
                    foreach ($toUpload as $item) {

                        $imageFile = $item['file'];
                        $hash = $item['hash'];

                        $resize = resize_image($imageFile);

                        $originalName = $resize['originalName'];
                        $uniqueName = $resize['uniqueName'];

                        $savePath = $publicFolder . $uniqueName;

                        if (!save_resize_image($resize, $savePath)) {
                            throw new Exception('Failed to upload image. Data not updated.');
                        }

                        $newImages[] = [
                            'file_name'   => $originalName,
                            'upload_folder' => $folder,
                            'public_path' => $dbPath . $uniqueName,
                            'file_hash'   => $hash,
                            'alt_text'    => $product->name,
                            'video_url'   => $validated['video_url'] ?? null,
                        ];
                    }

                    // Delete old images from storage & database
                    foreach ($oldImages as $oldImage) {

                        $imagePath = public_path($oldImage->public_path);

                        if (!empty($oldImage->public_path) && File::exists($imagePath)) {
                            File::delete($imagePath);
                        }

                        $oldImage->delete();
                    }

                    $product->images()->createMany($newImages);
                }

                $brand = Brand::find($validated['brand_id'] ?? null);

                $colorIds = $validated['color_id'] ?? [];
                $sizeIds  = $validated['size_id'] ?? [];

                $colors = Color::whereIn('id', array_filter($colorIds))
                    ->get()
                    ->keyBy('id');

                $sizes = Size::whereIn('id', array_filter($sizeIds))
                    ->get()
                    ->keyBy('id');


                $allSkus = [];
                foreach ($validated['variant_id'] ?? [] as $index => $variantId) {

                    $variant = ProductVariant::where('id', $variantId)
                        ->where('product_id', $product->id)
                        ->first();

                    if (!$variant) {
                        continue;
                    }

                    $colorId = $colorIds[$index] ?? null;
                    $sizeId  = $sizeIds[$index] ?? null;

                    $color = $colors->get($colorId);
                    $size  = $sizes->get($sizeId);

                    $discountStart = null;
                    $discountEnd = null;

                    if (!empty($validated['discount_start'][$index])) {
                        $discountStart = Carbon::parse(
                            $validated['discount_start'][$index]
                        );
                    }

                    if (!empty($validated['discount_end'][$index])) {
                        $discountEnd = Carbon::parse(
                            $validated['discount_end'][$index]
                        );
                    }

                    if ($discountStart && $discountEnd && $discountEnd->lt($discountStart)) {

                        throw new Exception(
                            'Discount End must be after or equal to Discount Start. Data not updated.'
                        );
                    }

                    $productName = Str::upper(
                        Str::substr($validated['name'] ?? 'PDT', 0, 3)
                    );

                    $brandName = Str::upper(
                        Str::substr($brand?->name ?? 'BND', 0, 3)
                    );

                    $colorName = Str::upper(
                        Str::substr($color?->name ?? 'CLR', 0, 3)
                    );

                    $sizeName = Str::upper(
                        Str::substr($size?->name ?? 'SZE', 0, 3)
                    );

                    $oldSku = $variant->sku ?? '';

                    $sku = sanitize_sku(
                        $validated['sku'][$index] ?? '',
                        $oldSku,
                        $productName,
                        $brandName,
                        $colorName,
                        $sizeName
                    );

                    if (in_array($sku, $allSkus, true)) {

                        throw new Exception("Duplicate SKU [ {$sku} ] found in request. Data not updated.");
                    }

                    $exists = ProductVariant::where('sku', $sku)
                        ->where('id', '!=', $variant->id)
                        ->exists();

                    if ($exists) {

                        throw new Exception("SKU [ {$sku} ] already exists. Data not updated.");
                    }

                    $allSkus[] = $sku;

                    $manageStock = (int)($validated['manage_stock'][$index] ?? 0) === 1;

                    $stockQuantity = (int)(
                        $validated['stock_quantity'][$index] ?? 0
                    );

                    if (!$manageStock) {
                        $stockQuantity = 0;
                    }

                    $stockStatus = $manageStock
                        ? ($stockQuantity > 0 ? 'in_stock' : 'out_of_stock')
                        : 'in_stock';


                    $regularPrice = (float)(
                        $validated['regular_price'][$index] ?? 0
                    );

                    $sellingPrice = (float)(
                        $validated['selling_price'][$index] ?? $regularPrice
                    );

                    $discountType =
                        $validated['discount_type'][$index] ?? 'none';

                    $discountValue = (float)(
                        $validated['discount_value'][$index] ?? 0
                    );

                    switch ($discountType) {

                        case 'fixed':

                            $sellingPrice = max(
                                0,
                                $regularPrice - $discountValue
                            );

                            break;


                        case 'percent':

                            $sellingPrice = max(
                                0,
                                $regularPrice -
                                    (($regularPrice * $discountValue) / 100)
                            );

                            break;
                    }

                    $sellingPrice = round($sellingPrice, 2);

                    $variant->update([
                        'color_id'       => $colorId,
                        'size_id'        => $sizeId,

                        'sku'            => $sku,

                        'regular_price'  => $regularPrice,
                        'selling_price'  => $sellingPrice,

                        'discount_type'  => $discountType,
                        'discount_value' => $discountValue,

                        'discount_start' => $discountStart?->format('Y-m-d H:i:s'),
                        'discount_end'   => $discountEnd?->format('Y-m-d H:i:s'),

                        'stock_quantity' => $stockQuantity,
                        'manage_stock'   => $manageStock,
                        'stock_status'   => $stockStatus,
                    ]);
                }

                DB::commit();

                return redirect()
                    ->route('homepage.index')
                    ->with('toastr_success', 'Product updated successfully !');
            } catch (Exception $error) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('toastr_error', $error->getMessage());
            }
        } else {
            return back()->with('toastr_error', 'Your account is temporarily blocked. Data not updated !');
        }
    }


    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if ($user && $user->role == 'admin' && $user->status == 1) {

            foreach ($product->images as $image) {

                $path = public_path($image->public_path);

                if (File::exists($path)) {
                    File::delete($path);
                }

                $image->delete();
            }

            $product->delete();

            return redirect()->route('admin.products.CRUD.index')
                ->with('toastr_success', 'Product deleted successfully !');
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
