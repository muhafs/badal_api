<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'province_id' => 'required|numeric|exists:provinces,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'City Name can\'t be Empty',

            'province_id.required' => 'Province can\'t be Empty',
            'province_id.exists' => 'no Province found',
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
