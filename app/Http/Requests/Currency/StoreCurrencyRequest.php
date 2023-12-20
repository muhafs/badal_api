<?php

namespace App\Http\Requests;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreCurrencyRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|unique:currencies,name',
            'code'          => 'required|string|unique:currencies,code',
            'country_id'    => 'required|numeric|exists:countries,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Currency Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'code.required' => 'Currency Code can\'t be Empty',
            'code.unique' => 'This code has already taken',

            'country_id.required' => 'Country is missing',
            'country_id.exsits' => 'no Country found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
