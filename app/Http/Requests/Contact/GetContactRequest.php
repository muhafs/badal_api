<?php

namespace App\Http\Requests\Contact;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetContactRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('contact'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:contacts,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Contact is missing',
            'numeric' => 'Contact is invalid',
            'exists' => 'No Contact found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
