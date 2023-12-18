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
        $provinces = ProvinceListResource::collection(Province::all());

        return $this->jsonResponse("Success", $provinces);
    }

    function show(GetProvinceRequest $request)
    {
        $province = new ProvinceResource(Province::find($request->id));

        return $this->jsonResponse("Success", $province);
    }

    function store(StoreProvinceRequest $request)
    {
        $province = Province::create([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id
        ]);

        if (!$province) {
            $this->throwResponse("Something went Error while Creating Province");
        }

        return $this->jsonResponse("Success Create Province", $province, 201);
    }

    function update(UpdateProvinceRequest $request)
    {
        $province = Province::find($request->id);

        $province->update([
            'name' => str($request->name)->title()->squish(),
            'country_id' => $request->country_id
        ]);

        if (!$province) {
            $this->throwResponse("Something went Error while Updating Province");
        }

        return $this->jsonResponse("Success Update Province", $province, 201);
    }

    function destroy(GetProvinceRequest $request)
    {
        $province = Province::destroy($request->id);

        if (!$province) {
            $this->throwResponse("Something went Error while Deleting Province");
        }

        return $this->jsonResponse("Success Delete Province", $province, 201);
    }
}
