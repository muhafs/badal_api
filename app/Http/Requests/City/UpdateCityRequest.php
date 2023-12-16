<?php

namespace App\Http\Requests\City;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateCityRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:cities,id',
            'name' => 'required|string',
            'province_id' => 'nullable|numeric|exists:provinces,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'City is missing',
            'id.numeric' => 'City is invalid',
            'id.exists' => 'No City found',

            'name.required' => 'City Name can\'t be Empty',

            'province_id.exists' => 'no Province found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse(400, $validator->errors()->first());
    }
}
