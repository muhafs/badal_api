<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:addresses,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Address is missing',
            'numeric' => 'Address is invalid',
            'exists' => 'No Address found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => $validator->errors()->first(),
                ],
                404
            )
        );
    }
}
