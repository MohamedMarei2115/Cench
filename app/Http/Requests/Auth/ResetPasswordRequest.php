<?php


namespace App\Http\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest  extends FormRequest
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
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required|size:50',
        ];
    }

}
