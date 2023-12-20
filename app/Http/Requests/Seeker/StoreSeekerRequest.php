<?php

namespace App\Http\Requests\Seeker;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreSeekerRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "hajj_name" => "nullable|string|max:32",
            "price" => "required|integer",
            "currency_id" => "required|numeric|exists:currencies,id",
            "user_id" => "required|numeric|exists:users,id"
        ];
    }

    public function messages()
    {
        return [
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
