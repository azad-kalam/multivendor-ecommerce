<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;


class ColorController extends Controller
{
    public function index()
    {
        $all_colors = Color::latest()->paginate(5);
        return view('admin.colors.CRUD.index', compact('all_colors'));
    }

    public function create()
    {
        return view('admin.colors.CRUD.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'status' => 'required',
        ]);

        if (Color::where('name', $request->name)->exists()) {
            return back()
                ->withInput()
                ->with('toastr_error', 'Color name already exists. Data not saved.');
        }

        if ($request->code && Color::where('code', $request->code)->exists()) {
            return back()
                ->withInput()
                ->with('toastr_error', 'Color code already exists. Data not saved.');
        }

        Color::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.colors.CRUD.index')
            ->with('toastr_success', 'Color created successfully');
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'status' => 'required',
        ]);

        if (
            Color::where('name', $request->name)
            ->where('id', '!=', $color->id)
            ->exists()
        ) {
            return back()
                ->withInput()
                ->with('toastr_error', 'Color name already exists. Data not saved.');
        }

        if (
            $request->code &&
            Color::where('code', $request->code)
            ->where('id', '!=', $color->id)
            ->exists()
        ) {
            return back()
                ->withInput()
                ->with('toastr_error', 'Color code already exists. Data not saved.');
        }

        $color->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.colors.CRUD.index')
            ->with('toastr_success', 'Color updated successfully');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return back()->with('toastr_success', 'Color deleted successfully');
    }

    public function color_status(string $id)
    {
        $color = Color::findOrFail($id);
        if ($color->status == 1) {
            $color->update(['status' => 0]);
            $message = 'Color deactivated successfully !';
        } else {
            $color->status == 0;
            $color->update(['status' => 1]);
            $message = 'Color activated successfully !';
        }
        $color->save();
        return back()->with('toastr_success', $message);
    }
}
