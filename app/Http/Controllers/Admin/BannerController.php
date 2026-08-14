<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Image;
use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{

    public function index()
    {
        $allBanners = Banner::with('images')
            ->latest()
            ->paginate(5);

        return view('admin.banners.CRUD.index', compact('allBanners'));
    }


    public function create()
    {
        return view('admin.banners.CRUD.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'         => 'required|array|min:1',
            'image.*'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'title'         => 'required|string|max:255',

            'type'          => 'required|in:hero,slider,offer,popup,featured',

            'occasion'      => 'nullable|string|max:255',

            'start_date'    => 'nullable|date',

            'end_date'      => 'nullable|date|after_or_equal:start_date',

            'offer_type'    => 'nullable|in:percentage,fixed',

            'offer_value'   => 'nullable|numeric|min:0',

            'slug'          => 'nullable|string|max:255',

            'status'        => 'required|boolean',
        ]);

        $savedFiles = [];
        $requestHashes = [];

        DB::beginTransaction();

        try {

            $slug = sanitize_slug(
                $validated['slug'] ?? $validated['title']
            );

            if (Banner::where('slug', $slug)->exists()) {
                throw new Exception("Slug [$slug] already exists.");
            }


            // $publicFolder = public_path('uploads/banners/');
            // $dbPath = 'uploads/banners/';

            $upload_folder = 'banners';

            $publicFolder = public_path("uploads/$upload_folder/");
            $dbPath = "uploads/$upload_folder/";

            if (! File::exists($publicFolder)) {
                File::makeDirectory($publicFolder, 0755, true);
            }


            foreach ($request->file('image') as $requestImage) {

                $hash = md5_file($requestImage->getRealPath());

                if (in_array($hash, $requestHashes, true)) {
                    throw new Exception('Duplicate image selected.');
                }

                $requestHashes[] = $hash;

                $existingImage = Image::where('upload_folder', $upload_folder)
                    ->where('file_hash', $hash)
                    ->first();

                if ($existingImage) {
                    throw new Exception(
                        "[ {$existingImage->file_name} ] Banner already exists. Data not saved."
                    );
                }
            }

            $banner = Banner::create([
                'title'        => $validated['title'],
                'type'         => $validated['type'],
                'occasion'     => $validated['occasion'] ?? null,
                'start_date'   => $validated['start_date'] ?? null,
                'end_date'     => $validated['end_date'] ?? null,
                'offer_type'   => $validated['offer_type'] ?? null,
                'offer_value'  => $validated['offer_value'] ?? 0,
                'slug'         => $slug,
                'status'       => $validated['status'],
            ]);


            foreach ($request->file('image') as $requestImage) {

                $hash = md5_file($requestImage->getRealPath());

                $image = resize_image($requestImage);

                $savePath = $publicFolder . $image['uniqueName'];

                save_resize_image($image, $savePath);

                $savedFiles[] = $savePath;

                $banner->images()->create([
                    'file_name'   => $image['originalName'],
                    'upload_folder' => $upload_folder,
                    'public_path' => $dbPath . $image['uniqueName'],
                    'file_hash'   => $hash,
                    'alt_text'    => $banner->type,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.banners.CRUD.index')
                ->with('toastr_success', 'Banner created successfully.');
        } catch (Throwable $e) {

            DB::rollBack();

            foreach ($savedFiles as $file) {

                if (File::exists($file)) {
                    File::delete($file);
                }
            }

            return back()
                ->withInput()
                ->with('toastr_error', $e->getMessage());
        }
    }


    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'image'         => 'nullable|array',
            'image.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'title'         => 'required|string|max:255',

            'type'          => 'required|in:hero,slider,offer,popup,featured',

            'occasion'      => 'nullable|string|max:255',

            'start_date'    => 'nullable|date',

            'end_date'      => 'nullable|date|after_or_equal:start_date',

            'offer_type'    => 'nullable|in:percentage,fixed',

            'offer_value'   => 'nullable|numeric|min:0',

            'slug'          => 'nullable|string|max:255',

            'status'        => 'required|boolean',
        ]);

        $savedFiles = [];
        $requestHashes = [];

        DB::beginTransaction();

        try {

            $slug = sanitize_slug(
                $validated['slug'] ?: $validated['title']
            );

            if (
                Banner::where('slug', $slug)
                ->where('id', '!=', $banner->id)
                ->exists()
            ) {
                throw new Exception("Slug [{$slug}] already exists.");
            }

            $folder = 'banners';
            $publicFolder = public_path("uploads/$folder/");
            $dbPath = "uploads/$folder/";

            if (!File::exists($publicFolder)) {
                File::makeDirectory($publicFolder, 0755, true);
            }


            if ($request->hasFile('image')) {

                foreach ($request->file('image') as $requestImage) {

                    $hash = md5_file($requestImage->getRealPath());

                    if (in_array($hash, $requestHashes, true)) {
                        throw new Exception('Duplicate image selected.');
                    }

                    $requestHashes[] = $hash;

                    $existingImage = Image::where('file_hash', $hash)
                        ->where(function ($query) use ($banner) {
                            $query->whereNull('banner_id')
                                ->orWhere('banner_id', '!=', $banner->id);
                        })
                        ->first();

                    if ($existingImage) {
                        throw new Exception(
                            "[ {$existingImage->file_name} ] Banner already exists. Data not updated."
                        );
                    }
                }
            }

            $banner->update([
                'title'        => $validated['title'],
                'type'         => $validated['type'],
                'occasion'     => $validated['occasion'],
                'start_date'   => $validated['start_date'],
                'end_date'     => $validated['end_date'],
                'offer_type'   => $validated['offer_type'],
                'offer_value'  => $validated['offer_value'] ?? 0,
                'slug'         => $slug,
                'status'       => $validated['status'],
            ]);


            if ($request->hasFile('image')) {

                foreach ($banner->images as $oldImage) {

                    $oldPath = public_path($oldImage->public_path);

                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }

                    $oldImage->delete();
                }

                foreach ($request->file('image') as $requestImage) {

                    $hash = md5_file($requestImage->getRealPath());

                    $image = resize_image($requestImage);

                    $savePath = $publicFolder . $image['uniqueName'];

                    save_resize_image($image, $savePath);

                    $savedFiles[] = $savePath;

                    $banner->images()->create([
                        'file_name'   => $image['originalName'],
                        'upload_folder' => $folder,
                        'public_path' => $dbPath . $image['uniqueName'],
                        'file_hash'   => $hash,
                        'alt_text'    => $banner->title,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.banners.CRUD.index')
                ->with('toastr_success', 'Banner updated successfully.');
        } catch (Throwable $e) {

            DB::rollBack();

            foreach ($savedFiles as $file) {

                if (File::exists($file)) {
                    File::delete($file);
                }
            }

            return back()
                ->withInput()
                ->with('toastr_error', $e->getMessage());
        }
    }


    public function destroy(string $id) // get id by modal form
    {
        $banner = Banner::findOrFail($id);

        $image = $banner->images->first();

        if ($image) {
            $imagePath = public_path($image->public_path);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $image->delete();
        }

        $banner->delete();

        return redirect()
            ->route('admin.banners.CRUD.index')
            ->with(
                'toastr_success',
                'Banner deleted successfully.'
            );
    }


    public function status(string $id)
    {
        $banner = Banner::findOrFail($id);

        $banner->update([
            'status' => !$banner->status
        ]);

        return back()->with(
            'toastr_success',
            $banner->status
                ? 'Banner activated successfully!'
                : 'Banner deactivated successfully!'
        );
    }
}
