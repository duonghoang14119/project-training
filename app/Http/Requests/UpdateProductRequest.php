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
            'name' => 'required|max:255',
            'category_id' => 'required|numeric',
            'manufacturer_id' => 'required|numeric',
            'price' => 'required|numeric|gt:0',
            'description' => 'max: 500'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please enter product name',
            'category_id.required' => 'Please select a category',
            'manufacturer_id.required' => 'Please select manufacturer',
            'price.required' => 'Please enter product price',
            'price.numeric' => 'Invalid product price',
            'price.gt' => 'The product price needs to be a positive number',
            'description.max' => 'Please enter product description less than 500 characters',
        ];
    }
}
