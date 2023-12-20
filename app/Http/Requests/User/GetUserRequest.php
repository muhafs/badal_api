<?php

namespace App\Http\Requests\User;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetUserRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('user'),
        ]);
    }

    public function rules()
    {
        return ['id' => 'required|numeric|exists:users,id'];
    }

    public function messages()
    {
        return [
            'required' => 'User is missing',
            'numeric' => 'User is invalid',
            'exists' => 'No User found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
