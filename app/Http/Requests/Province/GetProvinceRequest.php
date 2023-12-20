<?php

namespace App\Http\Requests\Province;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetProvinceRequest extends FormRequest
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

    public function rules()
    {
        return ['id' => 'required|numeric|exists:provinces,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Province is missing',
            'numeric' => 'Province is invalid',
            'exists' => 'No Province found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
