<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product.name' => 'required',
            'product.description' => 'required',
            'product.cost_price' => 'required',
            'product.price' => 'required',
            'product.sale_price' => 'required',
            'product.sku' => 'required',
            'product.quantity' => 'required',
            'product.featured_image' => 'required',
            'product.images' => 'nullable',
            'product.category_id' => 'required',
            'product.brand_id' => 'required',
            'product.status' => 'required'
            ];
    }
}
