<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\City\CityResource;
use App\Http\Requests\City\GetCityRequest;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Http\Resources\City\CityListResource;

class CityController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $cities = CityListResource::collection(City::with('province')->get());

        $this->jsonResponse(200, 'Success', $cities);
    }

    function show(GetCityRequest $request)
    {
        $city = new CityResource(City::with('province')->find($request->id));

        $this->jsonResponse(200, 'Success', $city);
    }

    function store(StoreCityRequest $request)
    {
        $city = City::create([
            'name' => str($request->name)->title()->squish(),
            'province_id' => $request->province_id
        ]);

        if ($city) {
            $this->jsonResponse(201, 'Success Create City', $city);
        } else {
            $this->errorResponse(400, 'Something went Error while Creating City');
        }
    }

    function update(UpdateCityRequest $request)
    {
        $city = City::find($request->id);

        $city->update([
            'name' => str($request->name ?? $city->name)->title()->squish(),
            'province_id' => $request->province_id ?? $city->province_id
        ]);

        if ($city) {
            $this->jsonResponse(201, 'Success Update City', $city);
        } else {
            $this->errorResponse(400, 'Something went Error while Updating City');
        }
    }

    function destroy(GetCityRequest $request)
    {
        $city = City::find($request->id);

        $city->delete();

        if ($city) {
            $this->jsonResponse(201, 'Success Delete City', $city);
        } else {
            $this->errorResponse(400, 'Something went Error while Deleting City');
        }
    }
}
