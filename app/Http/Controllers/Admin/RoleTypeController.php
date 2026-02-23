<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RoleTypeController extends Controller
{
    // vendor details start here
    public function vendor()
    {
        $vendor_details = User::where('role', 'vendor')->paginate(5);
        return view('admin.all_vendor.index', compact('vendor_details'));
    }

    public function vendor_edit($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        return view('admin.all_vendor.edit', compact('vendor'));
    }

    public function vendor_update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,vendor,user',
        ]);

        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $vendor->role = $request->role;
        $vendor->save();

        return redirect()->route('admin.all_vendor.index')
            ->with('session_success_toastr', 'Vendor data updated successfully !');
    }

    public function vendor_destroy($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $vendor->delete();

        return redirect()->route('admin.all_vendor.index')->with('session_success', 'Vendor data deleted successfully !');
    }
    // vendor details end here


    // user details start here
    public function user()
    {
        $user_details = User::where('role', 'user')->paginate(5);
        return view('admin.all_user.index', compact('user_details'));
    }

    public function user_edit($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        return view('admin.all_user.edit', compact('user'));
    }

    public function user_update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,vendor,user',
        ]);

        $user = User::where('role', 'user')->findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.all_user.index')
            ->with('session_success_toastr', 'User data updated successfully !');
    }

    public function user_destroy($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.all_user.index')->with('session_success', 'User data deleted successfully !');
    }
    // user details end here
}
