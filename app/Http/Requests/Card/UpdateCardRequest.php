<?php


namespace App\Http\Requests\Card;


use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
            'card_id' => 'required|exists:cards,id',
            'title' => 'required|string|min:1|max:255',
            'description' => 'sometimes',
            'level' => 'required|in:easy,medium,hard',
            'time' => 'required|numeric',
            'app_week' => 'required|in:true,false',
            'status' => 'sometimes|in:true,false',
            'du_date' => 'required|date_format:Y-m-d'
        ];
    }
}
