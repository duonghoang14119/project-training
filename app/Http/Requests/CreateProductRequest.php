<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required|max:255|unique:products,name',
            'category_id' => 'required',
            'manufacturer_id' => 'required',
            'price' => 'required|numeric|gt:0',
            'description' => 'max: 500',
            'image_path' => 'required|image|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter product name',
            'name.unique' => 'Product name already exists',
            'category_id.required' => 'Please select a category',
            'manufacturer_id.required' => 'Please select manufacturer',
            'price.required' => 'Please enter product price',
            'price.numeric' => 'Invalid product price',
            'price.gt' => 'The product price needs to be a positive number',
            'description.max' => 'Please enter product description less than 500 characters',
            'image_path.required' => 'Please select product image',
            'image_path.image' => 'Invalid image',
            'image_path.max' => 'Images should not exceed 1MB',
        ];
    }

}
