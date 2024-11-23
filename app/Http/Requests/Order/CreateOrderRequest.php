<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:255',
            'company_name' => 'sometimes',
            'country' => 'required|string|min:1|max:255',
            'address' => 'required|string|min:1|max:255',
            'city' => 'required|string|min:1|max:255',
            'province' => 'required|string|min:1|max:255',
            'post_code' => 'required|min:1|max:255',
            'phone' => 'required|min:1|max:255',
            'email' => 'required|string|min:1|max:255',
            'total' => 'required|min:1|max:255',
            'products' => 'required|array',
            'products.*.name' => 'required|string|min:1|max:255',
            'products.*.quantity' => 'required|integer|min:1|max:255',
            'products.*.size' => 'required|string|min:1|max:255',
            'products.*.price' => 'required|numeric|min:1|max:255',
        ];
    }
}
