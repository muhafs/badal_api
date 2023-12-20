<?php

namespace App\Http\Resources\Seeker;

use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Http\Resources\Json\JsonResource;

class SeekerListResource extends JsonResource
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
            "available" => $this->available ? true : false,
            "hajj_name" => $this->hajj_name,

            "offer" => Number::currency($this->price, $this->currency->code),

            "currency" => $this->currency->code,
            "user" => $this->user->first_name
        ];
    }
}
