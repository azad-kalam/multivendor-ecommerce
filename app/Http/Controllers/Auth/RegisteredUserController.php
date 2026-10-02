<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Throwable;
use App\Models\User;
use App\Models\Profile;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RegisteredUserController extends Controller
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = ImageManager::gd();
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'about'     => ['nullable', 'string'],
            'company'   => ['nullable', 'string', 'max:255'],
            'job'       => ['nullable', 'string', 'max:255'],
            'country'   => ['nullable', 'string', 'max:255'],
            'address'   => ['nullable', 'string', 'max:255'],
            'phone'     => ['required', 'digits:11', 'unique:users,phone'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'facebook'  => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin'  => ['nullable', 'url', 'max:255'],
            'password'  => ['required', 'confirmed', Password::defaults()],
        ]);

        $folder = 'profiles';
        $publicFolder = public_path("uploads/{$folder}/");
        $dbPath = "uploads/{$folder}/";

        if (!File::exists($publicFolder)) {
            File::makeDirectory($publicFolder, 0755, true);
        }

        $hash = null;

        if ($request->hasFile('image')) {

            $requestImage = $request->file('image');
            $hash = md5_file($requestImage->getRealPath());

            $existingImage = Image::where('upload_folder', $folder)
                ->where('file_hash', $hash)
                ->first();

            if ($existingImage) {
                return back()
                    ->withInput()
                    ->with('toastr_error', "[ {$existingImage->file_name} ] Image already exists. Data not saved.");
            }
        }

        DB::beginTransaction();

        try {

            $user = User::create([
                'name'              => $validated['name'],
                'email'             => $validated['email'],
                'phone'             => $validated['phone'],
                'password'          => Hash::make($validated['password']),
                'last_login_time'   => now(),
                'last_ip_address'   => $request->ip(),
            ]);

            $profile = $user->profile()->create([
                'about'     => $validated['about'] ?? null,
                'company'   => $validated['company'] ?? null,
                'job'       => $validated['job'] ?? null,
                'country'   => $validated['country'] ?? null,
                'address'   => $validated['address'] ?? null,
                'twitter'   => $validated['twitter'] ?? null,
                'facebook'  => $validated['facebook'] ?? null,
                'instagram' => $validated['instagram'] ?? null,
                'linkedin'  => $validated['linkedin'] ?? null,
            ]);


            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $data = resize_image($image);

                $originalName = $data['originalName'];
                $uniqueName   = $data['uniqueName'];

                save_resize_image($data, $publicFolder . $uniqueName);

                $profile->image()->create([
                    'file_name'      => $originalName,
                    'upload_folder'  => $folder,
                    'public_path'    => $dbPath . $uniqueName,
                    'file_hash'      => $hash,
                    'alt_text'       => $user->name,
                ]);
            }

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            return redirect()
                ->route('homepage.index')
                ->with('toastr_success', 'Registration successfully completed.');
        } catch (Throwable $error) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('toastr_error', $error->getMessage());
        }
    }
}
