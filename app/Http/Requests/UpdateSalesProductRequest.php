<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'data' => ['required', 'array'],
            'data.trader_name' => ['filled', 'string'],
            'data.trader_phone_number' => ['filled', 'string'],
            'data.sales_type' => ['filled', 'string'],
            'data.amount_paid' => ['filled', 'numeric'],
            'data.next_pay_at' => ['nullable', 'string'],
            'data.products' => ['filled', 'array'],
            'data.products.*.id' => ['filled', 'integer'],
            'data.products.*.price' => ['filled', 'string'],
        ];
    }
}
