<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'required|string',
            'postcode' => 'required|string|max:10',
            'city_id' => 'required|numeric|exists:cities,id',
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'Address Name can\'t be Empty',

            'postcode.required' => 'Postal Code can\'t be Empty',
            'postcode.max' => 'Postal Code maximal 10 Digits',

            'city_id.required' => 'City can\'t be Empty',
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
