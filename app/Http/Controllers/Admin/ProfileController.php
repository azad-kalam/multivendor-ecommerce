<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // লগইন করা ইউজার

        if ($user) {
            $profile = Profile::with('image')->where('user_id', $user->id)->first();

            return view('admin.profile.index', compact('user', 'profile'));
        } else {
            return redirect()
                ->route('homepage.index')
                ->with('toastr_error', 'You are not logged in.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()
    //             ->route('homepage.index')
    //             ->with('toastr_error', 'You are not logged in.');
    //     }

    //     $profile = Profile::with('image')
    //         ->where('user_id', $user->id)
    //         ->first();

    //     return view('admin.profile.edit', compact('user', 'profile'));
    // }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Profile relation ধরে data fetch করছি
        $profile = Profile::with('image')->where('user_id', $user->id)->first();
        return view('admin.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
