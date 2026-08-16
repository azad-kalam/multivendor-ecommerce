<?php

namespace App\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // public function rules(): array
    // {
    //     return [
    //         'product_id'         => 'required|exists:products,id',
    //         'product_variant_id' => 'required|exists:product_variants,id',
    //         'product_size' => 'required|string',
    //         'product_quantity'   => 'required|integer|min:1',
    //     ];
    // }


    public function rules(): array
    {
        return [

            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'product_variant_id' => [
                'required',
                'integer',
                'exists:product_variants,id',
            ],

            'product_size' => [
                'required',
                'integer',
            ],

            'product_color' => [
                'required',
                'integer',
            ],

            'product_quantity' => [
                'required',
                'integer',
                'min:1',
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'product_id.required' =>
            'Product is required.',

            'product_id.exists' =>
            'Selected product does not exist.',

            'product_variant_id.required' =>
            'Product variant is required.',

            'product_variant_id.exists' =>
            'Selected product variant does not exist.',

            'product_size.required' =>
            'Please select a size.',

            'product_size.integer' =>
            'Invalid size selected.',

            'product_color.required' =>
            'Please select a color.',

            'product_color.integer' =>
            'Invalid color selected.',

            'product_quantity.required' =>
            'Quantity is required.',

            'product_quantity.integer' =>
            'Quantity must be a number.',

            'product_quantity.min' =>
            'Quantity must be at least 1.',

        ];
    }
}
