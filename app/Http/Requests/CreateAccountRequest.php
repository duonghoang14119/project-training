<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter user name',
            'email.unique' => 'User email already exists',
            'email.required' => 'Please enter email',
            'password.required' => 'Please enter password',
            'password.confirmed' => 'Confirm password is incorrect',
        ];
    }
}
