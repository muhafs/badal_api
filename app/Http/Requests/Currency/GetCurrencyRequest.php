<?php

namespace App\Http\Requests\Currency;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetCurrencyRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('currency'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:currencies,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Currency is missing',
            'numeric' => 'Currency is invalid',
            'exists' => 'No Currency found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
