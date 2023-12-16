<?php

namespace App\Http\Requests\Province;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreProvinceRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'country_id' => 'required|numeric|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Province Name can\'t be Empty',

            'country_id.required' => 'Country can\'t be Empty',
            'country_id.exists' => 'no Country found',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse(400, $validator->errors()->first());
    }
}
