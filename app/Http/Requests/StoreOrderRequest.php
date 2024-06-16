<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'products' => ['array', 'required', 'min:1'],
            'products.*.product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'products.*.quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
        ];
    }

    /**
     * handle the error response from the validation
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ],Response::HTTP_BAD_REQUEST));
    }
}
