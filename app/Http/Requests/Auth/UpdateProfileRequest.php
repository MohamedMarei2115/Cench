<?php


namespace App\Http\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->user()->id),
                'regex:/^[A-Za-z0-9_&]+$/',
            ],
            'password' => 'min:6|max:20|confirmed',
            'password_confirmation' => 'required_with:password',
            'avatar' => 'sometimes'
        ];
    }

}
