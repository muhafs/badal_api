<?php

namespace App\Http\Requests\City;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetCityRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('city'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:cities,id'];
    }

    public function messages()
    {
        return [
            'required' => 'City is missing',
            'numeric' => 'City is invalid',
            'exists' => 'No City found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
