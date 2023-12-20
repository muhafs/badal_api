<?php

namespace App\Http\Requests\Seeker;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetSeekerRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('seeker'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:seekers,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Seeker is missing',
            'numeric' => 'Seeker is invalid',
            'exists' => 'No Seeker found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
