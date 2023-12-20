<?php

namespace App\Http\Requests\Phone;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetPhoneRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('phone'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:phones,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Phone is missing',
            'numeric' => 'Phone is invalid',
            'exists' => 'No Phone found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
