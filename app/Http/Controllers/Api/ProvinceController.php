<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use App\Http\Controllers\Controller;
use App\Http\Resources\Province\ProvinceResource;
use App\Http\Requests\Province\GetProvinceRequest;
use App\Http\Requests\Province\StoreProvinceRequest;
use App\Http\Requests\Province\UpdateProvinceRequest;
use App\Http\Resources\Province\ProvinceListResource;

class ProvinceController extends Controller
{
    function index()
    {
        $provinces = Province::with('country')->get();

        return response()->json([
            'message' => 'Success',
            'data' => ProvinceListResource::collection($provinces)
        ], 200);
    }

    function show(GetProvinceRequest $request)
    {
        $province = Province::with('country')->find($request->id);

        return response()->json([
            'message' => 'Success',
            'data' => new ProvinceResource($province)
        ], 200);
    }

    function store(StoreProvinceRequest $request)
    {
        $province = Province::create([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id
        ]);

        if ($province) {
            return response()->json([
                'message' => 'Success Create Province'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Creating Province'
            ], 400);
        }
    }

    function update(UpdateProvinceRequest $request)
    {
        $province = Province::find($request->id);

        $province->update([
            'name' => str($request->name ?? $province->name)->title()->squish(),
            'country_id' => $request->country_id ?? $province->country_id
        ]);

        if ($province) {
            return response()->json([
                'message' => 'Success Update Province'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Updating Province'
            ], 400);
        }
    }

    function destroy(GetProvinceRequest $request)
    {
        $province = Province::find($request->id);

        $province->delete();

        if ($province) {
            return response()->json([
                'message' => 'Success Delete Province'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Deleting Province'
            ], 400);
        }
    }
}
