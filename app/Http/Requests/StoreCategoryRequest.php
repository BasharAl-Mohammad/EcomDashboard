<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'category.name' => 'required|unique:categories,name',
            'category.description' => 'nullable',
            'category.image' => 'nullable',
            'category.parent_id' => 'nullable',
            'category.status' => 'required'
        ];
    }
}
