<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetCountryRequest extends FormRequest
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
        return ['id' => 'required|numeric|exists:countries,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Country is missing',
            'numeric' => 'Country is invalid',
            'exists' => 'No Country found'
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
