<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSalesRequest extends FormRequest
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
            'created_by' => ['required', 'exists:users,user_id'],
            'name' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'type' => ['required', Rule::in(['purchased', 'sold'])],
            'status' => ['required', Rule::in(['not_paid', 'not_fully_paid', 'paid'])],
            'pay_at' => ['required', 'date']

        ];
    }
}
