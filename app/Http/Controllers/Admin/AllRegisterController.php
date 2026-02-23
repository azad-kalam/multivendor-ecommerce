<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Pagination\Paginator;

class AllRegisterController extends Controller
{
    public function index()
    {
        $all_register = User::paginate(5);
        return view('admin.all_register_info.index', compact('all_register'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'numeric'],
            'role' => ['required', 'in:admin,vendor,user,customer'],
            'password' => ['required', 'confirmed', Password::default()],
            // 'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.all_register_info.index')
            ->with('session_success', 'Registration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // use show modal
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // use edit modal
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:admin,vendor,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('admin.all_register_info.index')
            ->with('session_success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('admin.all_register_info.index')
            ->with('session_delete', 'Register record deleted successfully.');
    }


    public function user_status(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 1) {
            $user->update(['status' => 0]);
            $message = 'User inactivated successfully !';
        } else {
            $user->status == 0;
            $user->update(['status' => 1]);
            $message = 'User activated successfully !';
        }
        $user->save();
        return back()->with('toastr_success', $message);
    }
}
