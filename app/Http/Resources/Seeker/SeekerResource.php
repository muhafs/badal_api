<?php

namespace App\Http\Resources\Seeker;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "user_id" => $this->user_id,

            "first_name" => $this->user->first_name,
            "last_name" => $this->user->last_name,

            "full_name" => $this->when($this->user->last_name, "{$this->user->first_name} {$this->user->last_name}", $this->user->first_name),
            "hajj_name" => $this->hajj_name,

            "type" => "Seeker",
            "gender" => str($this->user->gender)->is("M") ? 'Male' : 'Female',

            "birth_date" => Carbon::createFromDate($this->user->birth_date)->toFormattedDateString(),
            "nationality" => $this->user->nationality->nationality,
            "image_porfile" => $this->user->getImageURL(),

            "currency" => $this->currency,
            "offer" => Number::currency($this->price, $this->currency),
            "available" => $this->available ? true : false,

            "email" => $this->user->contact->email,
            "phone_code" => $this->user->contact->phone_code,
            "phone_number" => $this->user->contact->phone_number,

            "whatsapp" => $this->user->contact->whatsapp,
            "instagram" => $this->when($this->user->contact->instagram, "@{$this->user->contact->instagram}", null),
            "facebook" => $this->user->contact->facebook,

            "address" => $this->user->address->address,
            "postcode" => $this->user->address->postcode,
            "city" => $this->user->address->city->name,
        ];
    }
}
