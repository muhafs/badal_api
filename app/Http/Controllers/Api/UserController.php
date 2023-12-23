<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserListResource;

class UserController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $users = UserListResource::collection(User::all());

        return $this->jsonResponse("Success", $users);
    }

    function show(GetUserRequest $request)
    {
        $user = new UserResource(User::find($request->id));

        return $this->jsonResponse("Success", $user);
    }

    function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id,
            'first_name' => str($request->first_name)->ucfirst()->trim(),
            'last_name' => trim($request->last_name) ? str($request->last_name)->ucfirst()->trim() : null,
            'gender' => str($request->gender)->upper()->trim(),
            'birth_date' => Carbon::make($request->birth_date)->toDateString(),
            'image' => null,
            'type' => str($request->type)->upper()->trim(),
            'nationality_id' => $request->nationality_id
        ]);

        if (!$user) {
            $this->throwResponse("Something went Error while Creating User");
        }

        if ($user->type == "SKR") {
            $user->seeker()->create([
                "hajj_name" => trim($request->hajj_name) ? str($request->hajj_name)->title()->squish() : null,
                "type" => str($request->seeker_type)->trim()->upper(),
                "currency_id" => $request->currency_id,
                "price" => $request->price
            ]);
        }

        if ($user->type == "PRF") {
            $user->performer()->create([
                "nickname" => trim($request->nickname) ? str($request->nickname)->title()->squish() : null,
                "bio" => trim($request->bio) ? str($request->bio)->ucfirst()->squish() : null
            ]);
        }

        $user->address()->create([
            'address' => str($request->address)->title()->squish(),
            'postcode' => str($request->postcode)->upper()->trim(),
            'city_id' => $request->city_id
        ]);

        $user->contact()->create([
            "phone_code_id" => $request->phone_code_id,
            "phone_number" => str($request->phone_number)->trim(),
            "email" => trim($request->email) ? str($request->email)->lower()->trim() : null,
            "whatsapp" => trim($request->whatsapp) ? str($request->whatsapp)->trim() : null,
            "instagram" => trim($request->instagram) ? str($request->instagram)->lower()->trim() : null,
            "facebook" => trim($request->facebook) ? str($request->facebook)->title()->squish() : null
        ]);

        return $this->jsonResponse("Success Create User", $user, 201);
    }

    function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);

        $user->update([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id,
            'first_name' => str($request->first_name)->ucfirst()->trim(),
            'last_name' => trim($request->last_name) ? str($request->last_name)->ucfirst()->trim() : null,
            'gender' => str($request->gender)->upper()->trim(),
            'birth_date' => Carbon::make($request->birth_date)->toDateString(),
            'image' => null,
            'type' => str($request->type)->upper()->trim(),
            'nationality_id' => $request->nationality_id
        ]);

        if (!$user) {
            $this->throwResponse("Something went Error while Updating User");
        }

        if ($user->type == "SKR") {
            $user->seeker->update([
                "hajj_name" => trim($request->hajj_name) ? str($request->hajj_name)->title()->squish() : null,
                "type" => str($request->seeker_type)->trim()->upper(),
                "currency_id" => $request->currency_id,
                "price" => $request->price
            ]);
        }

        if ($user->type == "PRF") {
            $user->performer->update([
                "nickname" => trim($request->nickname) ? str($request->nickname)->title()->squish() : null,
                "bio" => trim($request->bio) ? str($request->bio)->ucfirst()->squish() : null
            ]);
        }

        $user->address->update([
            'address' => str($request->address)->title()->squish(),
            'postcode' => str($request->postcode)->upper()->trim(),
            'city_id' => $request->city_id
        ]);

        $user->contact->update([
            "phone_code_id" => $request->phone_code_id,
            "phone_number" => str($request->phone_number)->trim(),
            "email" => str($request->email)->trim(),
            "whatsapp" => str($request->whatsapp)->trim(),
            "instagram" => str($request->instagram)->lower()->trim(),
            "facebook" => str($request->facebook)->title()->squish()
        ]);

        return $this->jsonResponse("Success Update User", $user, 201);
    }

    function destroy(GetUserRequest $request)
    {
        $user = User::destroy($request->id);

        if (!$user) {
            $this->throwResponse("Something went Error while Deleting User");
        }

        return $this->jsonResponse("Success Delete User", $user, 201);
    }
}
