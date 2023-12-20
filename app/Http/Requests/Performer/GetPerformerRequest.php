<?php

namespace App\Http\Requests\Performer;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetPerformerRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('performer'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:performers,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Performer is missing',
            'numeric' => 'Performer is invalid',
            'exists' => 'No Performer found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
