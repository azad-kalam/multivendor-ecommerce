<?php

namespace App\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $routeName = $this->route()?->getName();

        $method = $this->method();

        $validation_rules = [];


        if ($routeName === 'frontend.carts.store' && $method === 'POST') {

            $validation_rules = [

                'product_id' => ['bail', 'required', 'integer', 'exists:products,id',],

                'product_variant_id' => [
                    'bail',
                    'required',
                    'integer',
                    Rule::exists('product_variants', 'id')
                        ->where(function ($query) {
                            $query->where('product_id', $this->product_id);
                        }),
                ],

                'product_quantity' => ['bail', 'required', 'integer', 'min:1', 'max:999',],

            ];
        }

        if ($routeName === 'frontend.carts.update' && $method === 'PATCH') {
            $validation_rules = [

                'product_quantity' => ['bail', 'required', 'integer', 'min:1', 'max:999',],

            ];
        }

        if ($routeName === 'frontend.carts.destroy' && $method === 'DELETE') {

            $validation_rules = [];
        }

        return $validation_rules;
    }


    public function messages(): array
    {
        return [
            'product_id.required' => 'Product is required.',
            'product_id.integer' => 'Product ID must be a valid number.',
            'product_id.exists' => 'Selected product not found.',

            'product_variant_id.required' => 'Variant is required.',
            'product_variant_id.integer' => 'Variant ID must be a valid number.',
            'product_variant_id.exists' => 'Selected variant does not belong to this product.',

            'product_quantity.required' => 'Quantity is required.',
            'product_quantity.integer' => 'Quantity must be a valid number.',

            'product_quantity.min' => 'Quantity must be at least 1.',
            'product_quantity.max' => 'Quantity cannot exceed 999.',
        ];
    }
}
