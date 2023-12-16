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
            "first_name" => 'required|string',
            "last_name" => 'nullable|string',
            "gender" => 'required|string|max:1|in:M,F,m,f',
            "birth_date" => 'nullable|date',
            "nationality_id" => 'required|numeric|exists:cities,id',

            "hajj_name" => 'nullable|string|max:32',
            "currency" => 'required|string|max:3',
            "price" => 'required|integer',

            "email" => 'nullable|email|unique:contacts,email',
            "phone_code" => 'required|numeric',
            "phone_number" => 'required|numeric|unique:contacts,phone_number',
            "whatsapp" => 'nullable|numeric|unique:contacts,whatsapp',
            "instagram" => 'nullable|string|unique:contacts,instagram',
            "facebook" => 'nullable|string|unique:contacts,facebook',

            "address" => 'required|string',
            "postcode" => 'nullable|string|max:10',
            "city_id" => 'required|numeric|exists:cities,id',
        ];
    }

    //TODO: has to be done
    public function messages()
    {
        return [
            'name.required' => 'Country Name can\'t be Empty',
            'name.unique' => 'This name has already taken',

            'nationality.required' => 'Nationality can\'t be Empty',
            'nationality.unique' => 'this nationality has already taken',

            'phone_code.required' => 'Phone code can\'t be Empty',
            'phone_code.numeric' => 'Phone code must be a number',
            'phone_code.unique' => 'this Phone code has already taken',

            'currency_code.required' => 'Currency code can\'t be Empty',
            'currency_code.max' => 'Currency code has to be 3 Characters',
            'currency_code.unique' => 'this Currency code has already taken',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->throwResponse($validator->errors()->first());
    }
}
