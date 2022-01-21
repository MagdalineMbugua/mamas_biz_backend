<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSalesRequest extends FormRequest
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
            'name' => ['filled', 'string'],
            'phone_number' => ['filled', 'string'],
            'type' => ['filled', Rule::in(['purchased', 'sold'])],
            'status' => ['filled', Rule::in(['not_paid', 'not_fully_paid', 'paid'])],
            'pay_at' => ['filled', 'date'],
        ];
    }
}
