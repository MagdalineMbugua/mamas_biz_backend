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
            'sales_id' => ['filled', 'exists:sales,sales_id'],
            'product_id' => ['filled', 'exists:products,product_id'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
        ];
    }
}
