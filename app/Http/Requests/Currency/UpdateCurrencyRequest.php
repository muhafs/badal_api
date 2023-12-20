<?php

namespace App\Http\Requests;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateCurrencyRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('currency'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:currencies,id',
            'name' => 'required|string|unique:currencies,name,' . $this->id,
            'code' => 'required|string|unique:currencies,code,' . $this->id,
            'country_id' => 'required|numeric|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Currency is missing',
            'id.numeric' => 'Currency is invalid',
            'id.exists' => 'No Currency found',

            'name.required' => 'Currency Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'code.required' => 'Currency Code can\'t be Empty',
            'code.unique' => 'This code has already taken',

            'country_id.required' => 'Country is missing',
            'country_id.*' => 'no Country found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
