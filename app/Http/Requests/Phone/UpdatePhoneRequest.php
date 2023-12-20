<?php

namespace App\Http\Requests\Phone;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdatePhoneRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('phone'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:phones,id',
            'code' => 'required|string|unique:phones,code,' . $this->id,
            'country_id' => 'required|numeric|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Phone is missing',
            'id.numeric' => 'Phone is invalid',
            'id.exists' => 'No Phone found',

            'code.required' => 'Phone Code can\'t be Empty',
            'code.unique' => 'This code has already taken',

            'country_id.required' => 'Country is missing',
            'country_id.*' => 'no Country found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
