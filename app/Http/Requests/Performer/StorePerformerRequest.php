<?php

namespace App\Http\Requests\Performer;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StorePerformerRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nickname" => "nullable|string|max:32",
            "bio" => "required|string",
            "user_id" => "required|numeric|exists:users,id"
        ];
    }

    public function messages()
    {
        return [
            "nickname.*" => "Nickname too long, max is 32 characters",

            "user_id.required" => "User is missing",
            "user_id.*" => "no User found"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
