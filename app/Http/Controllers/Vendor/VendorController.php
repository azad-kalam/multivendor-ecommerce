<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
{
    // Show vendor details page
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'vendor') {
            $vendor = Auth::user();
            return view('vendor.details.index', compact('vendor'));
        }
        abort(403);
    }

    // Update vendor info
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('vendor.details.index')
            ->with('session_success_toastr', 'Vendor data updated successfully!');
    }

    // Delete vendor account
    public function destroy($id)
    {
        if (Auth::id() != $id) {
            abort(403);
        }

        $vendor_user = Auth::user();

        $vendor_user->delete();

        return redirect()
            ->route('homepage.index')
            ->with('session_flash', 'Vendor account deleted successfully!');
    }

}
