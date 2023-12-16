<?php

namespace App\Http\Requests\Address;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetAddressRequest extends FormRequest
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

    public function rules()
    {
        return ['id' => 'required|numeric|exists:addresses,id'];
    }

    public function messages()
    {
        return [
            'required' => 'Address is missing',
            'numeric' => 'Address is invalid',
            'exists' => 'No Address found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first(), 404);
    }
}
