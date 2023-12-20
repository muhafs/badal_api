<?php

namespace App\Http\Requests\Contact;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreContactRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "phone_number" => "required|numeric|unique:contacts,phone_number",
            "email" => "nullable|email|unique:contacts,email",
            "whatsapp" => "nullable|numeric|unique:contacts,whatsapp",
            "instagram" => "nullable|string|unique:contacts,instagram",
            "facebook" => "nullable|string",
            "user_id" => "required|numeric|exists:users,id",
            "phone_code_id" => "required|numeric|exists:phones,id"
        ];
    }

    public function messages()
    {
        return [
            "phone_number.required" => "Phone Number can't be Empty",
            "phone_number.numeric" => "Phone Number invalid",
            "phone_number.unique" => "Phone Number has already taken",

            "email.email" => "Email is invalid",
            "email.unique" => "this Email has already taken",

            "whatsapp.numeric" => "WhatsApp Number invalid",
            "whatsapp.unique" => "this WhatsApp Number has already taken",

            "instagram.unique" => "Instagram has already taken",

            "user_id.required" => "User is missing",
            "user_id.exsits" => "no User found",

            "phone_code_id.required" => "Phone Code is missing",
            "phone_code_id.exsits" => "no Phone Code found"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
