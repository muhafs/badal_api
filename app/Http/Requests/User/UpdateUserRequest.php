<?php

namespace App\Http\Requests\User;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "id" => $this->route("user"),
        ]);
    }

    public function rules(): array
    {
        return [
            //? User
            "id"          => "required|numeric|exists:users,id",
            "first_name"          => "required|string",
            "last_name"          => "nullable|string",
            "gender"          => "required|string|max:1|in:M,F,m,f",
            "birth_date"          => "nullable|date",
            "image"          => "nullable|image|max:2048",
            "type"          => "required|string|in:SKR,PRF,ADM",
            "nationality_id"    => "required|numeric|exists:nationalities,id",

            //? Seeker
            "hajj_name" => "nullable|string|max:32",
            "type" => "required|string|in:HAJJ,UMRAH",
            "price" => "required_if:type,SKR|integer",
            "currency_id" => "required_if:type,SKR|numeric|exists:currencies,id",

            //? Performer
            "nickname" => "nullable|string|max:32",
            "bio" => "nullable|string",

            //? Address
            "address" => "required|string",
            "postcode" => "required|string|max:10",
            "city_id" => "required|numeric|exists:cities,id",

            //? Contact
            "phone_number" => "required|numeric|unique:contacts,phone_number," . $this->id,
            "email" => "nullable|email|unique:contacts,email," . $this->id,
            "whatsapp" => "nullable|numeric|unique:contacts,whatsapp," . $this->id,
            "instagram" => "nullable|string|unique:contacts,instagram," . $this->id,
            "facebook" => "nullable|string",
            "phone_code_id" => "required|numeric|exists:phones,id"
        ];
    }

    public function messages()
    {
        return [
            //? User
            "id.required" => "User is missing",
            "id.numeric" => "User is invalid",
            "id.exists" => "No User found",

            "first_name.required" => "First Name can't be Empty",
            "gender.*" => "Gender is invalid",
            "birth_date.*" => "Birth Date is invalid",
            "image.max" => "Image is too large, max 2MB",
            "type.*" => "Type is is invalid",

            "nationality_id.required" => "Nationality is missing",
            "nationality_id.exsits" => "no Nationality found",

            //? Seeker
            "hajj_name.*" => "Hajj name too long, max is 32 characters",

            "seeker_type.required" => "Type is missing",
            "seeker_type.*" => "Type is invalid",

            "price.required_if" => "Price can't be Empty",
            "price.integer" => "Price must be a number",

            "currency_id.required" => "Currency is missing",
            "currency_id.*" => "no Currency found",

            //? Performer
            "nickname.*" => "Nickname too long, max is 32 characters",

            //? Address
            "address.required" => "Address Name can't be Empty",

            "postcode.required" => "Postal Code can't be Empty",
            "postcode.max" => "Postal Code maximal 10 Digits",

            "city_id.required" => "City is missing",
            "city_id.exists" => "no City found",

            //? Contact
            "phone_number.required" => "Phone Number can't be Empty",
            "phone_number.numeric" => "Phone Number invalid",
            "phone_number.unique" => "Phone Number has already taken",

            "email.email" => "Email is invalid",
            "email.unique" => "this Email has already taken",

            "whatsapp.numeric" => "WhatsApp Number invalid",
            "whatsapp.unique" => "this WhatsApp Number has already taken",

            "instagram.unique" => "Instagram has already taken",

            "phone_code_id.required" => "Phone Code is missing",
            "phone_code_id.exsits" => "no Phone Code found"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
