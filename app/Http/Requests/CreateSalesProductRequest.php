<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSalesProductRequest extends FormRequest
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
            'data.trader_name' => ['required', 'string'],
            'data.trader_phone_number' => ['required', 'string'],
            'data.sales_type' => ['required', 'string'],
            'data.amount_paid' => ['required', 'numeric'],
            'data.next_pay_at' => ['nullable', 'string'],
            'data.products' => ['required', 'array'],
            'data.products.*.product_name' => ['required', 'string'],
            'data.products.*.price' => ['required', 'string'],
            'data.products.*.uom' => ['required', 'string'],
            'data.products.*.quantity' => ['required', 'string'],
            'data.products.*.product_type' => ['required', 'string'],
        ];
    }
}
