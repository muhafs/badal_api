<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Address\AddressResource;
use App\Http\Requests\Address\GetAddressRequest;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\Address\AddressListResource;

class AddressController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $addresses = AddressListResource::collection(Address::with('city', 'user')->get());

        $this->jsonResponse(200, 'Success', $addresses);
    }

    function show(GetAddressRequest $request)
    {
        $address = new AddressResource(Address::with('city', 'user')->find($request->id));

        $this->jsonResponse(200, 'Success', $address);
    }

    function store(StoreAddressRequest $request)
    {
        $address = Address::create([
            'address' => str($request->address)->title()->squish(),
            'postcode' => $request->postcode,
            'city_id' => $request->city_id
        ]);

        if ($address) {
            $this->jsonResponse(201, 'Success Create Address', $address);
        } else {
            $this->errorResponse(400, 'Something went Error while Creating Address');
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
            $this->jsonResponse(201, 'Success Update Address', $address);
        } else {
            $this->errorResponse(400, 'Something went Error while Updating Address');
        }
    }

    function destroy(GetAddressRequest $request)
    {
        $address = Address::find($request->id);

        $address->delete();

        if ($address) {
            $this->jsonResponse(201, 'Success Delete Address', $address);
        } else {
            $this->errorResponse(400, 'Something went Error while Deleting Address');
        }
    }
}
