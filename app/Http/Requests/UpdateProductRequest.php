<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'product_name'=>['filled', 'string'],
            'price'=>['filled', 'regex:/^\d+(\.\d{1,2})?$/'],
            'product_type'=>['filled', Rule::in( ['meat_product', 'cattle'])]
        ];
    }
}
