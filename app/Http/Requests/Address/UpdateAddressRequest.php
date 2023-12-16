<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAddressRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:addresses,id',
            'address' => 'required|string',
            'postcode' => 'required|string|max:10',
            'city_id' => 'nullable|numeric|exists:cities,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'City is missing',
            'id.numeric' => 'City is invalid',
            'id.exists' => 'No City found',

            'address.required' => 'Address Name can\'t be Empty',

            'postcode.required' => 'Postal Code can\'t be Empty',
            'postcode.max' => 'Postal Code maximal 10 Digits',

            'city_id.exists' => 'no City found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => $validator->errors()->first(),
                ],
                400
            )
        );
    }
}
