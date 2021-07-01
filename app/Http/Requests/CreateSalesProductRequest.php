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
            'sales_id'=>['required', 'exists:sales,sales_id'],
            'product_id'=>['required', 'exists:products,product_id'],
            'price'=>['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
