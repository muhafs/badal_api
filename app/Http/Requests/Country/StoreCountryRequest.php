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
            'short_code' => 'required|string|unique:countries,short_code|min:2|max:2',
            'long_code' => 'required|string|unique:countries,long_code|min:3|max:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Country Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'short_code.required' => 'Short code can\'t be Empty',
            'short_code.unique' => 'this Short code has already taken',
            'short_code.*' => 'Short code should be 2 characters',

            'long_code.required' => 'Long code can\'t be Empty',
            'long_code.unique' => 'this Long code has already taken',
            'long_code.*' => 'Long code should be 3 characters'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
