<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'data'=>['required', 'array'],
            'data.*.product_id' => ['required', 'integer'],
            'data.*.price' => ['required', 'string'],
            'data.*.quantity' => ['required', 'string'],
        ];
    }
}
