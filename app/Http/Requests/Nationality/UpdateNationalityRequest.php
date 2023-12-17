<?php

namespace App\Http\Requests\Nationality;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateNationalityRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:nationalities,id',
            'name' => 'required|string|unique:nationalities,name,' . $this->id,
            'country_id' => 'nullable|numeric|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Nationality is missing',
            'id.numeric' => 'Nationality is invalid',
            'id.exists' => 'No Nationality found',

            'name.required' => 'Nationality Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'country_id.*' => 'no Country found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
