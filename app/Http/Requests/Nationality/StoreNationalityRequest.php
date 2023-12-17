<?php

namespace App\Http\Requests\Nationality;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreNationalityRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|unique:nationalities,name',
            'country_id'    => 'required|numeric|exists:countries,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nationality Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'country_id.required' => 'Country is missing',
            'country_id.exsits' => 'no Country found'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
