<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "phone_number" => $this->phone_number,
            "email" => $this->email,
            "whatsapp" => $this->whatsapp,
            "instagram" => $this->instagram,
            "facebook" => $this->facebook,
            "user" => $this->user->first_name,
            "phone_code" => $this->phone_code->code
        ];
    }
}
