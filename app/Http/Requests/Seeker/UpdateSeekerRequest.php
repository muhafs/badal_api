<?php

namespace App\Http\Requests\Seeker;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateSeekerRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('seeker'),
        ]);
    }

    public function rules(): array
    {
        return [
            "id"            => "required|numeric|exists:seekers,id",
            "hajj_name"     => "nullable|string|max:32",
            "price"         => "required|integer",
            "currency_id"   => "required|numeric|exists:currencies,id",
            "user_id"       => "required|numeric|exists:users,id"
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Seeker is missing',
            'id.numeric' => 'Seeker is invalid',
            'id.exists' => 'No Seeker found',

            "hajj_name.*" => "Hajj name too long, max is 32 characters",

            "currency.required" => "Currency is missing",
            "currency.*" => "Currency is invalid",

            "price.required" => "Price can't be Empty",
            "price.integer" => "Price must be a number",

            "currency_id.required" => "Currency is missing",
            "currency_id.*" => "no Currency found",

            "user_id.required" => "User is missing",
            "user_id.*" => "no User found"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
