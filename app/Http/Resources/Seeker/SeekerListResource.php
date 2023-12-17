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
            "user_id" => $this->user_id,

            "first_name" => $this->user->first_name,
            "last_name" => $this->user->last_name,

            "gender" => str($this->user->gender)->is("M") ? 'Male' : 'Female',
            "nationality" => $this->user->nationality->nationality,

            "currency" => $this->currency,
            "offer" => Number::currency($this->price, $this->currency),

            "available" => $this->available ? true : false,
            "image_porfile" => $this->user->getImageURL(),
        ];
    }
}
