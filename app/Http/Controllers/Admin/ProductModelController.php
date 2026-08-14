<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\ProductModel;
use Illuminate\Support\Str;

class ProductModelController extends Controller
{

    public function index()
    {
        $product_models = ProductModel::with('brand')->paginate(5);

        return view('admin.product_models.CRUD.index', compact('product_models'));
    }


    public function create()
    {
        $brands = Brand::get();
        return view('admin.product_models.CRUD.create', compact('brands'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|array',
            'name.*' => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);

        $inserted = [];
        $skipped = [];

        foreach ($request->name as $modelName) {

            $modelName = trim($modelName);

            $exists = ProductModel::where('brand_id', $request->brand_id)
                ->where('name', $modelName)
                ->exists();

            if ($exists) {
                $skipped[] = $modelName;
                continue;
            }

            ProductModel::create([
                'brand_id' => $request->brand_id,
                'name' => $modelName,
                'slug' => Str::slug($modelName),
                'status' => $request->status,
            ]);

            $inserted[] = $modelName;
        }

        if (!empty($inserted)) {
            $successMessage = count($inserted) . " model (s) added successfully.";
        }

        if (!empty($skipped)) {
            $errorMessage = "Existing model (s) skipped : " . implode(', ', $skipped);
        }

        return redirect()
            ->route('admin.product_models.CRUD.index')
            ->with('toastr_success', $successMessage ?? null)
            ->with('toastr_error', $errorMessage ?? null);
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);

        $model = ProductModel::findOrFail($id);

        $model->update([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return back()->with(
            'toastr_success',
            'Model updated successfully!'
        );
    }

    public function destroy(string $id)
    {
        $model = ProductModel::findOrFail($id);

        $model->delete();

        return back()->with(
            'toastr_success',
            'Model deleted successfully!'
        );
    }


    public function model_status(string $id)
    {
        $product_model = ProductModel::findOrFail($id);
        if ($product_model->status == 1) {
            $product_model->update(['status' => 0]);
            $message = 'Model deactivated successfully !';
        } else {
            $product_model->status == 0;
            $product_model->update(['status' => 1]);
            $message = 'Model activated successfully !';
        }
        $product_model->save();
        return back()->with('toastr_success', $message);
    }
}
