<?php

namespace App\Http\Controllers\Api;

use App\Models\Phone;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Phone\PhoneResource;
use App\Http\Requests\Phone\GetPhoneRequest;
use App\Http\Requests\Phone\StorePhoneRequest;
use App\Http\Requests\Phone\UpdatePhoneRequest;
use App\Http\Resources\Phone\PhoneListResource;

class PhoneController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $phones = PhoneListResource::collection(Phone::all());

        return $this->jsonResponse("Success", $phones);
    }

    function show(GetPhoneRequest $request)
    {
        $phone = new PhoneResource(Phone::find($request->id));

        return $this->jsonResponse("Success", $phone);
    }

    function store(StorePhoneRequest $request)
    {
        $phone = Phone::create([
            "code" => $request->code,
            "country_id" => $request->country_id,
        ]);

        if (!$phone) {
            $this->throwResponse("Something went Error while Creating Phone");
        }

        return $this->jsonResponse("Success Create Phone", $phone, 201);
    }

    function update(UpdatePhoneRequest $request)
    {
        $phone = Phone::find($request->id);

        $phone->update([
            "code" => $request->code,
            "country_id" => $request->country_id,
        ]);

        if (!$phone) {
            $this->throwResponse("Something went Error while Updating Phone");
        }

        return $this->jsonResponse("Success Update Phone", $phone, 201);
    }

    function destroy(GetPhoneRequest $request)
    {
        $phone = Phone::destroy($request->id);

        if (!$phone) {
            $this->throwResponse("Something went Error while Deleting Phone");
        }

        return $this->jsonResponse("Success Delete Phone", $phone, 201);
    }
}
