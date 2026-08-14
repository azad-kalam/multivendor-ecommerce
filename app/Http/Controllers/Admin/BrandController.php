<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{

    public function index()
    {
        $allBrands = Brand::with('images')
            ->latest()
            ->paginate(10);

        return view('admin.brands.CRUD.index', compact('allBrands'));
    }

    public function create()
    {
        return view('admin.brands.CRUD.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {

            if (Brand::where('name', $validated['name'])->exists()) {
                throw new Exception('Brand name already exists. Data not saved.');
            }

            $slug = sanitize_slug($request->slug ?: $validated['name']);

            if (Brand::where('slug', $slug)->exists()) {
                throw new Exception("[$slug] slug already exists. Data not saved.");
            }

            $folder = 'brands';
            $hash = null;

            if ($request->hasFile('image')) {

                $requestImage = $request->file('image');

                $hash = md5_file($requestImage->getRealPath());

                $existingImage = Image::where('file_hash', $hash)
                    ->whereNotNull('brand_id')
                    ->exists();

                if ($existingImage) {
                    throw new Exception('Brand Logo already exists. Data not saved.');
                }
            }

            $brand = Brand::create([
                'name'   => $validated['name'],
                'slug'   => $slug,
                'status' => $validated['status'],
            ]);

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $publicFolder = public_path("uploads/{$folder}/");
                $dbPath = "uploads/{$folder}/";

                if (!File::exists($publicFolder)) {
                    File::makeDirectory($publicFolder, 0755, true);
                }

                $data = resize_image($image);

                $originalName = $data['originalName'];
                $uniqueName   = $data['uniqueName'];

                $filePath = $publicFolder . $uniqueName;

                save_resize_image($data, $filePath);

                $brand->images()->create([

                    'file_name'      => $originalName,
                    'upload_folder'  => $folder,
                    'public_path'    => $dbPath . $uniqueName,
                    'file_hash'      => $hash,
                    'alt_text'       => $brand->name,

                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.brands.CRUD.index')
                ->with('toastr_success', 'Brand created successfully.');
        } catch (Throwable $error) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('toastr_error', $error->getMessage());
        }
    }


    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'logo'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $hash = null;

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $hash = md5_file($file->getRealPath());

            $existingImage = Image::where('file_hash', $hash)
                ->where('imageable_id', '!=', $brand->id)
                ->exists();

            if ($existingImage) {

                return back()
                    ->withInput()
                    ->with(
                        'toastr_error',
                        'Logo already exists. Data not updated.'
                    );
            }
        }

        $brand->update([
            'name'   => $validated['name'],
            'slug'   => Str::slug($validated['name']) . '-' . time(),
            'status' => $validated['status'],
        ]);

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $publicFolder = public_path('uploads/brands/');
            $dbPath = 'uploads/brands/';

            if (!File::exists($publicFolder)) {
                File::makeDirectory($publicFolder, 0755, true);
            }

            $data = resize_image($file);

            $img = $data['img'];
            $originalName = $data['originalName'];
            $uniqueName = $data['uniqueName'];

            $oldImage = $brand->images->first();

            if ($oldImage) {

                $oldImagePath = public_path(
                    $oldImage->public_path
                );

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $oldImage->delete();
            }

            $img->save(
                $publicFolder . $uniqueName,
                quality: 80
            );

            $brand->images()->updateOrCreate([
                'file_name'   => $originalName,
                'public_path' => $dbPath . $uniqueName,
                'file_hash'   => $hash,
                'alt_text'    => $validated['name'],
            ]);
        }

        return redirect()
            ->route('admin.brands.CRUD.index')
            ->with(
                'toastr_success',
                'Brand updated successfully.'
            );
    }


    public function destroy(string $id) // get id by modal form
    {
        $brand = Brand::findOrFail($id);

        $image = $brand->images->first();

        if ($image) {
            $imagePath = public_path($image->public_path);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $image->delete();
        }

        $brand->delete();

        return redirect()
            ->route('admin.brands.CRUD.index')
            ->with(
                'toastr_success',
                'Brand deleted successfully.'
            );
    }

    public function status(string $id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->status == 1) {
            $brand->update(['status' => 0]);
            $message = 'Brand deactivated successfully !';
        } else {
            $brand->status == 0;
            $brand->update(['status' => 1]);
            $message = 'Brand activated successfully !';
        }
        $brand->save();
        return back()->with('toastr_success', $message);
    }
}
