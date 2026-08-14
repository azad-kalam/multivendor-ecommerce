<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{

    public function index()
    {
        $all_sizes = Size::orderBy('id', 'asc')->paginate(5);

        return view('admin.sizes.CRUD.index', compact('all_sizes'));
    }


    public function create()
    {
        return view('admin.sizes.CRUD.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        // Size name আগে থেকেই আছে কিনা চেক
        if (Size::where('name', $request->name)->exists()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('toastr_error', 'Size already exists. Data not saved.');
        }

        Size::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.sizes.CRUD.index')
            ->with('toastr_success', 'Size created successfully.');
    }


    public function update(Request $request, string $id) //get id by modal form
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $exists = Size::where('name', $request->name)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('admin.sizes.CRUD.index')
                ->with('toastr_error', 'Size name already exist. Data not updated.');
        }

        $size->update([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.sizes.CRUD.index')
            ->with('toastr_success', 'Size updated successfully.');
    }


    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('admin.sizes.CRUD.index')->with('toastr_success', 'Size deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $size = Size::findOrFail($id);
        if ($size->status == 1) {
            $size->update(['status' => 0]);
            $message = 'Size deactivated successfully !';
        } else {
            $size->status == 0;
            $size->update(['status' => 1]);
            $message = 'Size activated successfully !';
        }
        $size->save();
        return back()->with('toastr_success', $message);
    }
}
