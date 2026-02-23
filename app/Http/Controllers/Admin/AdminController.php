<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Show admin list
    public function index()
    {
        $admin_details = User::where('role', 'admin')->paginate(5);
        return view('admin.details.index', compact('admin_details'));
    }

    // Show create form
    public function create()
    {
        return view('admin.details.create');
    }

    // Store new admin
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'regex:/^[0-9]{10,11}$/', 'unique:users,phone'],
            'role' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        return redirect()
            ->route('admin.details.index')
            ->with('session_success', 'Admin data created successfully!');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if (auth()->id() !== $user->id || auth()->user()->role !== $user->role) {
            return redirect()
                ->route('admin.details.index')
                ->with('toastr_error', 'You are not allowed to update another admin account.');
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'phone' => [
                'required',
                'regex:/^[0-9]{10,11}$/',
                Rule::unique('users', 'phone')->ignore($id)
            ],
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => strtolower($validatedData['email']),
            'phone' => $validatedData['phone'],
            'role' => $user->role, // এখানে ডাটাবেসের একই রোল থাকবে
        ]);

        return redirect()
            ->route('admin.details.index')
            ->with('toastr_success', 'Your account updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $admin_user = User::findOrFail($id);
        if (auth()->id() === $admin_user->id && auth()->user()->role === $admin_user->role) {
            Auth::logout();          // প্রথমে লগআউট
            $admin_user->delete();   // তারপর ডিলিট

            return redirect()
                ->route('homepage.index')
                ->with('toastr_success', 'Your account deleted successfully!');
        } else {
            return redirect()
                ->route('admin.details.index')
                ->with('toastr_error', 'You are not allowed to delete another admin account.');
        }
    }

}
