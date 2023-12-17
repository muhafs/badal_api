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
            "first_name" => "required|string",
            "last_name" => "nullable|string",
            "gender" => "required|string|max:1|in:M,F,m,f",
            "birth_date" => "nullable|date",
            "nationality_id" => "required|numeric|exists:nationalities,id",

            "hajj_name" => "nullable|string|max:32",
            "currency" => "required|string|max:3",
            "price" => "required|integer",

            "email" => "nullable|email|unique:contacts,email",
            "phone_code" => "required|numeric",
            "phone_number" => "required|numeric|unique:contacts,phone_number",

            "whatsapp" => "nullable|numeric|unique:contacts,whatsapp",
            "instagram" => "nullable|string|unique:contacts,instagram",
            "facebook" => "nullable|string|unique:contacts,facebook",

            "address" => "required|string",
            "postcode" => "nullable|string|max:10",
            "city_id" => "required|numeric|exists:cities,id",
        ];
    }

    public function messages()
    {
        return [
            "first_name.required" => "Seeker Name can't be Empty",

            "gender.required" => "Gender is missing",
            "gender.*" => "Gender is invalid",

            "birth_date.date" => "Birth date format is invalid",

            "nationality_id.required" => "Nationality is missing",
            "nationality_id.*" => "Nationality is invalid",

            "hajj_name.max" => "Hajj name is too long, max is 32 characters",

            "currency.required" => "Currency is missing",
            "currency.*" => "Currency is invalid",

            "price.integer" => "Price can't be Empty",
            "price.integer" => "Price must be a number",

            "email.email" => "Email is invalid",
            "email.unique" => "this Email has already taken",

            "phone_code.required" => "Phone code is missing",
            "phone_code.numeric" => "Phone code must be a number",

            "phone_number.required" => "Phone number can't be Empty",
            "phone_number.numeric" => "Phone number must be a number",
            "phone_number.unique" => "this Phone number has already taken",

            "whatsapp.numeric" => "Whatsapp account must be a number",
            "whatsapp.unique" => "this Whatsapp account has already taken",

            "instagram.unique" => "this Instagram User has already taken",
            "facebook.unique" => "this Facebook User has already taken",

            "address.required" => "Address can't be Empty",
            "postcode.max" => "Post Code is too long, max 10 digits",

            "city_id.required" => "City is missing",
            "city_id.*" => "no City found",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
