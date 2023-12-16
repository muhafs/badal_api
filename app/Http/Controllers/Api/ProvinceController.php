<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Province\ProvinceResource;
use App\Http\Requests\Province\GetProvinceRequest;
use App\Http\Requests\Province\StoreProvinceRequest;
use App\Http\Requests\Province\UpdateProvinceRequest;
use App\Http\Resources\Province\ProvinceListResource;

class ProvinceController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $provinces = ProvinceListResource::collection(Province::with('country')->get());

        $this->jsonResponse(200, "Success", $provinces);
    }

    function show(GetProvinceRequest $request)
    {
        $province = new ProvinceResource(Province::with('country')->find($request->id));

        $this->jsonResponse(200, "Success", $province);
    }

    function store(StoreProvinceRequest $request)
    {
        $province = Province::create([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id
        ]);

        if ($province) {
            $this->jsonResponse(201, "Success Create Province", $province);
        } else {
            $this->errorResponse(400, "Something went Error while Creating Province");
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
            $this->jsonResponse(201, "Success Update Province", $province);
        } else {
            $this->errorResponse(400, "Something went Error while Updating Province");
        }
    }

    function destroy(GetProvinceRequest $request)
    {
        $province = Province::find($request->id);

        $province->delete();

        if ($province) {
            $this->jsonResponse(201, "Success Delete Province", $province);
        } else {
            $this->errorResponse(400, "Something went Error while Deleting Province");
        }
    }
}
