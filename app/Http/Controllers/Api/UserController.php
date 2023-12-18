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
            'last_name' => str($request->last_name)->trim()->isEmpty() ? null : str($request->last_name)->ucfirst()->trim(),,
            'gender' => str($request->gender)->upper()->trim(),
            'birth_date' => Carbon::make($request->birth_date)->toDateString(),
            'image' => null,
            'type' => str($request->type)->upper()->trim(),
            'nationality_id' => $request->nationality_id
        ]);

        if (!$user) {
            $this->throwResponse("Something went Error while Creating User");
        }

        return $this->jsonResponse("Success Create User", $user, 201);
    }

    function update(UpdateUserRequest $request)
    {
        $user = User::find($request->id);

        $user->update([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id,
            'first_name' => str($request->first_name)->ucfirst()->trim(),
            'last_name' => str($request->last_name)->trim()->isEmpty() ? null : str($request->last_name)->ucfirst()->trim(),,
            'gender' => str($request->gender)->upper()->trim(),
            'birth_date' => Carbon::make($request->birth_date)->toDateString(),
            'image' => null,
            'type' => str($request->type)->upper()->trim(),
            'nationality_id' => $request->nationality_id
        ]);

        if (!$user) {
            $this->throwResponse("Something went Error while Updating User");
        }

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
