<?php

namespace App\Http\Requests\Address;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateAddressRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
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
        $this->throwResponse($validator->errors()->first());
    }
}
