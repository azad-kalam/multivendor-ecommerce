<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Profile;
use App\Models\Image;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::with('image')->where('user_id', $user->id)->first();

        return view('admin.profile.index', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::with('image')->where('user_id', $user->id)->first();
        return view('admin.profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {

        $user = Auth::user();
        $request->validate([
            'name' => 'nullable|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            'twitter_profile' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?twitter\.com\/[A-Za-z0-9_\.]+$/',
            'facebook_profile' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[A-Za-z0-9\.]+$/',
            'instagram_profile' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9_\.]+$/',
            'linkedin_profile' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/.*$/',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);


        // update profiles table
        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'about' => $request->about,
                'company' => $request->company,
                'job' => $request->job,
                'country' => $request->country,
                'address' => $request->address,
                'twitter' => $request->twitter_profile,
                'facebook' => $request->facebook_profile,
                'instagram' => $request->instagram_profile,
                'linkedin' => $request->linkedin_profile
            ]
        );

        if ($request->hasFile('profile_image')) {

            $path = public_path('uploads/profile/');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // delete old image
            if ($profile->image) {

                $oldImagePath = public_path($profile->image->public_path);

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $profile->image()->delete();
            }

            $file = $request->file('profile_image');
            $OriginalFileName = $file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();

            $fileName = time() . '_' . uniqid() . '.' . $extension;

            $file->move($path, $fileName);

            Image::create([
                'profile_id' => $profile->id,
                'file_name' => $OriginalFileName,
                'public_path' => 'uploads/profile/' . $fileName,
                'file_hash' => md5_file($path . $fileName),
                'alt_text' => $user->name . ' profile image'
            ]);

        }

        return redirect()->route('admin.profile.index')
            ->with('toastr_success', 'Profile Updated Successfully');

    }

    public function changePassword()
    {
        return view('admin.profile.index');
    }
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => 'required',
            'newpassword' => 'required|string|min:8',
            'renewpassword' => 'required|string|min:8',
        ]);

        // check current password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('toastr_error', 'Current password is incorrect.');
        }

        // check new password match
        if ($request->newpassword !== $request->renewpassword) {
            return back()->with('toastr_error', 'New password and confirmation password do not match.');
        }

        // update password
        $user->password = Hash::make($request->newpassword);
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('toastr_success', 'Password updated successfully.');
    }
}
