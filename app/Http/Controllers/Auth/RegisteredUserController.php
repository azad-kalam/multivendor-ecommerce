<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'name' => ['required', 'string', 'max:255'],
            'registerImage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,avif,webp', 'max:2048'],
            'about' => ['nullable', 'string'],
            'company' => ['nullable', 'string', 'max:255'],
            'job' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'digits:11', 'unique:users,phone'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Duplicate Image Check
        if ($request->hasFile('registerImage')) {

            $imageFile = $request->file('registerImage');
            $imageHash = md5_file($imageFile->getRealPath());

            if (Image::where('file_hash', $imageHash)->exists()) {
                return back()->withInput()
                    ->with('toastr_error', 'This image already exists.');
            }
        }

        // Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'last_login_time' => now(),
            'last_ip_address' => $request->ip(),
        ]);

        // Create Profile
        $profile = $user->profile()->create([
            'about' => $validated['about'] ?? null,
            'company' => $validated['company'] ?? null,
            'job' => $validated['job'] ?? null,
            'country' => $validated['country'] ?? null,
            'address' => $validated['address'] ?? null,
            'twitter' => $validated['twitter'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
        ]);

        // Image Upload (Intervention v3)
        if ($request->hasFile('registerImage')) {
            $imageFile = $request->file('registerImage');
            $imageHash = md5_file($imageFile->getRealPath());
            $originalName = $imageFile->getClientOriginalName();
            $ext = $imageFile->getClientOriginalExtension();
            $uniqueName = time() . '_' . uniqid() . '.' . $ext;

            $folderPath = public_path('uploads/images/');

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            $image = $this->manager->read($imageFile->getRealPath());
            $image = $image->cover(300, 300);
            $image->save($folderPath . $uniqueName);
            $image->save($folderPath . $uniqueName);

            $profile->image()->create([
                'file_name' => $originalName,
                'public_path' => 'uploads/images/' . $uniqueName,
                'file_hash' => $imageHash,
                'alt_text' => $user->name,
            ]);
        }

        // Login
        event(new Registered($user));
        Auth::login($user);

        return redirect()
            ->route('homepage.index')
            ->with('toastr_success', 'Registration successfully completed.');
    }
}
