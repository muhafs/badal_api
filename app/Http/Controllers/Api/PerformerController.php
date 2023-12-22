<?php

namespace App\Http\Controllers\Api;

use App\Models\Performer;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Performer\PerformerResource;
use App\Http\Requests\Performer\GetPerformerRequest;
use App\Http\Requests\Performer\StorePerformerRequest;
use App\Http\Requests\Performer\UpdatePerformerRequest;
use App\Http\Resources\Performer\PerformerListResource;

class PerformerController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $performers = PerformerListResource::collection(Performer::all());

        return $this->jsonResponse("Success", $performers);
    }

    function show(GetPerformerRequest $request)
    {
        $performer = new PerformerResource(Performer::find($request->id));

        return $this->jsonResponse("Success", $performer);
    }

    function store(StorePerformerRequest $request)
    {
        $performer = Performer::create([
            "user_id" => $request->user_id,
            "nickname" => trim($request->nickname) ? str($request->nickname)->title()->squish() : null,
            "bio" => trim($request->bio) ? str($request->bio)->ucfirst()->squish() : null
        ]);

        if (!$performer) {
            $this->throwResponse("Something went Error while Creating Performer");
        }

        return $this->jsonResponse("Success Create Performer", $performer, 201);
    }

    function update(UpdatePerformerRequest $request)
    {
        $performer = Performer::find($request->id);

        $performer->update([
            "user_id" => $request->user_id,
            "nickname" => $request->nickname,
            "nickname" => trim($request->nickname) ? str($request->nickname)->title()->squish() : null,
            "bio" => trim($request->bio) ? str($request->bio)->ucfirst()->squish() : null
        ]);

        if (!$performer) {
            $this->throwResponse("Something went Error while Updating Performer");
        }

        return $this->jsonResponse("Success Update Performer", $performer, 201);
    }

    function destroy(GetPerformerRequest $request)
    {
        $performer = Performer::destroy($request->id);

        if (!$performer) {
            $this->throwResponse("Something went Error while Deleting Performer");
        }

        return $this->jsonResponse("Success Delete Performer", $performer, 201);
    }
}
