<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'postcode' => $this->postcode,
            'address' => $this->address,
            'city' => new CityResource($this->whenLoaded('city')),
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
