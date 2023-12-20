<?php

namespace App\Http\Resources\Seeker;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Currency\CurrencyResource;

class SeekerResource extends JsonResource
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

            "currency" => new CurrencyResource($this->whenLoaded("currency")),
            "user" => new UserResource($this->whenLoaded("user"))
        ];
    }
}
