<?php

namespace App\Http\Requests\User;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'          => 'required|string',
            'last_name'          => 'nullable|string',
            'gender'          => 'required|string|max:1|in:M,F,m,f',
            'birth_date'          => 'nullable|date',
            'image'          => 'nullable|image|max:2048',
            'type'          => 'required|string|in:SKR,PRF,ADM',
            'nationality_id'    => 'required|numeric|exists:nationalities,id'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name can\'t be Empty',

            'gender.*' => 'Gender is invalid',
            'birth_date.*' => 'Birth Date is invalid',
            'image.max' => 'Image is too large, max 2MB',
            'type.*' => 'Type is is invalid',

            'nationality_id.required' => 'Nationality is missing',
            'nationality_id.exsits' => 'no Nationality found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
