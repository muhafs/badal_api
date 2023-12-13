<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'id' => 'required|numeric|exists:countries,id',
            'name' => 'required|string|unique:countries,name,' . $this->id,
            'nationality' => 'required|string|unique:countries,nationality,' . $this->id,
            'phone_code' => 'required|numeric|unique:countries,phone_code,' . $this->id,
            'currency_code' => 'required|string|unique:countries,currency_code,' . $this->id,
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Country is missing',
            'id.numeric' => 'Country is invalid',
            'id.exists' => 'No Country found',

            'name.required' => 'Country Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'nationality.required' => 'Nationality can\'t be Empty',
            'nationality.unique' => 'this nationality has already taken',

            'phone_code.required' => 'Phone code can\'t be Empty',
            'phone_code.numeric' => 'Phone code must be a number',
            'phone_code.unique' => 'this Phone code has already taken',

            'currency_code.required' => 'Currency code can\'t be Empty',
            'currency_code.unique' => 'this Currency code has already taken',
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
