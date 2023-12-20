<?php

namespace App\Http\Requests\City;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreCityRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'province_id' => 'required|numeric|exists:provinces,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'City Name can\'t be Empty',

            'province_id.required' => 'Province is missing',
            'province_id.exists' => 'no Province found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
