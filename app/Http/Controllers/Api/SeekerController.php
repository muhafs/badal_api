<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Seeker;
use App\Models\Address;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Seeker\SeekerResource;
use App\Http\Requests\Seeker\GetSeekerRequest;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Requests\Seeker\UpdateSeekerRequest;
use App\Http\Resources\Seeker\SeekerListResource;

class SeekerController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $seekers = SeekerListResource::collection(Seeker::all());

        return $this->jsonResponse("Success", $seekers);
    }

    function show(GetSeekerRequest $request)
    {
        $seeker = new SeekerResource(Seeker::find($request->id));

        return $this->jsonResponse("Success", $seeker);
    }

    function store(StoreSeekerRequest $request)
    {
        $seeker = Seeker::create([
            "user_id" => $request->user_id,
            "hajj_name" => trim($request->hajj_name) ? str($request->hajj_name)->title()->squish() : null,
            "currency_id" => $request->currency_id,
            "price" => $request->price
        ]);

        if (!$seeker) {
            $this->throwResponse("Something went Error while Creating Seeker");
        }

        return $this->jsonResponse("Success Create Seeker", $seeker, 201);
    }

    function update(UpdateSeekerRequest $request)
    {
        $seeker = Seeker::find($request->id);

        $seeker->update([
            "user_id" => $request->user_id,
            "hajj_name" => trim($request->hajj_name) ? str($request->hajj_name)->title()->squish() : null,
            "currency_id" => $request->currency_id,
            "price" => $request->price
        ]);

        if (!$seeker) {
            $this->throwResponse("Something went Error while Updating Seeker");
        }

        return $this->jsonResponse("Success Update Seeker", $seeker, 201);
    }

    function destroy(GetSeekerRequest $request)
    {
        $seeker = Seeker::destroy($request->id);

        if (!$seeker) {
            $this->throwResponse("Something went Error while Deleting Seeker");
        }

        return $this->jsonResponse("Success Delete Seeker", $seeker, 201);
    }
}
