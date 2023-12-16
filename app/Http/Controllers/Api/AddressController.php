<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Traits\ResponseJson;
use App\Http\Controllers\Controller;
use App\Http\Resources\Address\AddressResource;
use App\Http\Requests\Address\GetAddressRequest;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\Address\AddressListResource;

class AddressController extends Controller
{
    use ResponseJson;

    function index()
    {
        $addresses = Address::with('city', 'user')->get();

        $this->successJson(
            'Success',
            AddressListResource::collection($addresses),
            200
        );
    }

    function show(GetAddressRequest $request)
    {
        $address = Address::with('city', 'user')->find($request->id);

        $this->successJson(
            'Success',
            new AddressResource($address),
            200
        );
    }

    function store(StoreAddressRequest $request)
    {
        $address = Address::create([
            'address' => str($request->address)->title()->squish(),
            'postcode' => $request->postcode,
            'city_id' => $request->city_id
        ]);

        if ($address) {
            $this->successJson(
                'Success Create Address',
                $address,
                201
            );
        } else {
            $this->errorJson('Something went Error while Creating Address', 400);
        }
    }

    function update(UpdateAddressRequest $request)
    {
        $address = Address::find($request->id);

        $address->update([
            'address' => str($request->address ?? $address->address)->title()->squish(),
            'postcode' => $request->postcode ?? $address->postcode,
            'city_id' => $request->city_id ?? $address->city_id
        ]);

        if ($address) {
            $this->successJson(
                'Success Update Address',
                $address,
                201
            );
        } else {
            $this->errorJson('Something went Error while Updating Address', 400);
        }
    }

    function destroy(GetAddressRequest $request)
    {
        $address = Address::find($request->id);

        $address->delete();

        if ($address) {
            $this->successJson(
                'Success Delete Address',
                $address,
                201
            );
        } else {
            $this->errorJson('Something went Error while Deleting Address', 400);
        }
    }
}
