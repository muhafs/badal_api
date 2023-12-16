<?php

namespace App\Http\Requests\Country;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetCountryRequest extends FormRequest
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
        $this->throwResponse(404, $validator->errors()->first());
    }
}
