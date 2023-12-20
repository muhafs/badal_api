<?php

namespace App\Http\Requests\Province;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateProvinceRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('province'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:provinces,id',
            'name' => 'required|string',
            'country_id' => 'required|numeric|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Province is missing',
            'id.numeric' => 'Province is invalid',
            'id.exists' => 'No Province found',

            'name.required' => 'Province Name can\'t be Empty',

            'country_id.required' => 'Country is missing',
            'country_id.exists' => 'no Country found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
