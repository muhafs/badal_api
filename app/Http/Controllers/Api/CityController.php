<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityResource;
use App\Http\Requests\City\GetCityRequest;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Http\Resources\City\CityListResource;

class CityController extends Controller
{
    function index()
    {
        $cities = City::with('province')->get();

        return response()->json([
            'message' => 'Success',
            'data' => CityListResource::collection($cities)
        ], 200);
    }

    function show(GetCityRequest $request)
    {
        $city = City::with('province')->find($request->id);

        return response()->json([
            'message' => 'Success',
            'data' => new CityResource($city)
        ], 200);
    }

    function store(StoreCityRequest $request)
    {
        $city = City::create([
            'name' => str($request->name)->title()->squish(),
            'province_id' => $request->province_id
        ]);

        if ($city) {
            return response()->json([
                'message' => 'Success Create City'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Creating City'
            ], 400);
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
            return response()->json([
                'message' => 'Success Update City'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Updating City'
            ], 400);
        }
    }

    function destroy(GetCityRequest $request)
    {
        $city = City::find($request->id);

        $city->delete();

        if ($city) {
            return response()->json([
                'message' => 'Success Delete City'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Deleting City'
            ], 400);
        }
    }
}
