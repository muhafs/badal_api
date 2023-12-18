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
        $cities = CityListResource::collection(City::all());

        return $this->jsonResponse('Success', $cities);
    }

    function show(GetCityRequest $request)
    {
        $city = new CityResource(City::find($request->id));

        return $this->jsonResponse('Success', $city);
    }

    function store(StoreCityRequest $request)
    {
        $city = City::create([
            'name' => str($request->name)->title()->squish(),
            'province_id' => $request->province_id
        ]);

        if (!$city) {
            $this->throwResponse('Something went Error while Creating City');
        }

        return $this->jsonResponse('Success Create City', $city, 201);
    }

    function update(UpdateCityRequest $request)
    {
        $city = City::find($request->id);

        $city->update([
            'name' => str($request->name)->title()->squish(),
            'province_id' => $request->province_id
        ]);

        if (!$city) {
            $this->throwResponse('Something went Error while Updating City');
        }

        return $this->jsonResponse('Success Update City', $city, 201);
    }

    function destroy(GetCityRequest $request)
    {
        $city = City::destroy($request->id);

        if (!$city) {
            $this->throwResponse('Something went Error while Deleting City');
        }

        return $this->jsonResponse('Success Delete City', $city, 201);
    }
}
