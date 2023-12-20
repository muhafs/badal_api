<?php

namespace App\Http\Resources\Performer;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformerResource extends JsonResource
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
            "nickname" => $this->nickname,
            "bio" => $this->bio,
            "user" => new UserResource($this->whenLoaded("user")),
        ];
    }
}
