<?php

namespace App\Http\Requests\Nationality;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetNationalityRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('nationality'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:nationalities,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Nationality is missing',
            'numeric' => 'Nationality is invalid',
            'exists' => 'No Nationality found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
