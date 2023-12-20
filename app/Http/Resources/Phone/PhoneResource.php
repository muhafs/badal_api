<?php

namespace App\Http\Resources\Phone;

use Illuminate\Http\Request;
use App\Http\Resources\Country\CountryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
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
            "code" => "+{$this->code}",
            "counry" => new CountryResource($this->whenLoaded("country"))
        ];
    }
}
