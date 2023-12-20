<?php

namespace App\Http\Requests\Performer;

use App\Http\Traits\HasJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdatePerformerRequest extends FormRequest
{
    use HasJsonResponse;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('performer'),
        ]);
    }

    public function rules(): array
    {
        return [
            "id"            => "required|numeric|exists:performers,id",
            "nickname" => "nullable|string|max:32",
            "bio" => "required|string",
            "user_id" => "required|numeric|exists:users,id"
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Performer is missing',
            'id.numeric' => 'Performer is invalid',
            'id.exists' => 'No Performer found',

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
