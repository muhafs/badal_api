<?php

namespace App\Http\Requests\Country;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreCountryRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:countries,name',
            'nationality' => 'required|string|unique:countries,nationality',
            'phone_code' => 'required|numeric|unique:countries,phone_code',
            'currency_code' => 'required|string|max:3|unique:countries,currency_code',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Country Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'nationality.required' => 'Nationality can\'t be Empty',
            'nationality.unique' => 'this nationality has already taken',

            'phone_code.required' => 'Phone code can\'t be Empty',
            'phone_code.numeric' => 'Phone code must be a number',
            'phone_code.unique' => 'this Phone code has already taken',

            'currency_code.required' => 'Currency code can\'t be Empty',
            'currency_code.max' => 'Currency code has to be 3 Characters',
            'currency_code.unique' => 'this Currency code has already taken',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
