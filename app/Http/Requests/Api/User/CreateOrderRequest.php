<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 403));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'product_id.*' => 'required|integer',
            'quantity' => 'required',
            'quantity.*' => 'required|integer',
        ];
    }
    public function message():array
    {
        return [
            'product_id.required' => 'The product id field is required.',
            'product_id.*.integer' => 'The product id must be a number.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.*.integer' => 'The quantity id must be a number.',
        ];
    }
}
