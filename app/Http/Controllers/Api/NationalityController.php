<?php

namespace App\Http\Controllers\Api;

use App\Models\Nationality;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Nationality\NationalityResource;
use App\Http\Requests\Nationality\GetNationalityRequest;
use App\Http\Requests\Nationality\StoreNationalityRequest;
use App\Http\Requests\Nationality\UpdateNationalityRequest;
use App\Http\Resources\Nationality\NationalityListResource;

class NationalityController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $nationalities = NationalityListResource::collection(Nationality::all());

        return $this->jsonResponse("Success", $nationalities);
    }

    function show(GetNationalityRequest $request)
    {
        $nationality = new NationalityResource(Nationality::find($request->id));

        return $this->jsonResponse("Success", $nationality);
    }

    function store(StoreNationalityRequest $request)
    {
        $nationality = Nationality::create([
            "name" => str($request->name)->ucfirst()->trim(),
            "country_id" => $request->country_id,
        ]);

        if (!$nationality) {
            $this->throwResponse("Something went Error while Creating Nationality");
        }

        return $this->jsonResponse("Success Create Nationality", $nationality, 201);
    }

    function update(UpdateNationalityRequest $request)
    {
        $nationality = Nationality::find($request->id);

        $nationality->update([
            "name" => str($request->name)->title()->squish(),
            "country_id" => $request->country_id,
        ]);

        if (!$nationality) {
            $this->throwResponse("Something went Error while Updating Nationality");
        }

        return $this->jsonResponse("Success Update Nationality", $nationality, 201);
    }

    function destroy(GetNationalityRequest $request)
    {
        $nationality = Nationality::destroy($request->id);

        if (!$nationality) {
            $this->throwResponse("Something went Error while Deleting Nationality");
        }

        return $this->jsonResponse("Success Delete Nationality", $nationality, 201);
    }
}
