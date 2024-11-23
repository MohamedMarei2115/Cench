<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users,username|regex:/^[A-Za-z0-9_&]+$/',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required',
            'country' => 'required',
            'gender' => 'required|in:male,female',
            'avatar' => 'sometimes'
        ];
    }

}
