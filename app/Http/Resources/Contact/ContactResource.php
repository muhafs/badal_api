<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Phone\PhoneResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            "user" => new UserResource($this->whenLoaded("user")),
            "phone_code" => new PhoneResource($this->whenLoaded("phone_code"))
        ];
    }
}
