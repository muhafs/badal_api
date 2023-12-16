<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use App\Http\Resources\City\CityResource;
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
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}
