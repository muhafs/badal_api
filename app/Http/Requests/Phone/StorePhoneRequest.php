<?php

namespace App\Http\Requests\Phone;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StorePhoneRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'          => 'required|string|unique:phones,code',
            'country_id'    => 'required|numeric|exists:countries,id'
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'phone Code can\'t be Empty',
            'code.unique' => 'This code has already taken',

            'country_id.required' => 'Country is missing',
            'country_id.exsits' => 'no Country found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
