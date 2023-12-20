<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
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

            "full_name" => $this->when($this->last_name, "{$this->first_name} {$this->last_name}", $this->first_name),
            "gender" => str($this->gender)->is("M") ? 'Male' : 'Female',

            "birth_date" => Carbon::createFromDate($this->birth_date)->toFormattedDateString(),
            "image" => $this->getImageURL(),

            "type" => str($this->type)->is("SKR") ? "Seeker" : (str($this->type)->is("PRF") ? "Performer" : "Admin"),
            "nationality" => $this->nationality->name
        ];
    }
}
