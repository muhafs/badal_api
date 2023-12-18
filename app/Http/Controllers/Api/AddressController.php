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
        $addresses = AddressListResource::collection(Address::all());

        return $this->jsonResponse('Success', $addresses);
    }

    function show(GetAddressRequest $request)
    {
        $address = new AddressResource(Address::find($request->id));

        return $this->jsonResponse('Success', $address);
    }

    function store(StoreAddressRequest $request)
    {
        $address = Address::create([
            'address' => str($request->address)->title()->squish(),
            'postcode' => str($request->postcode)->upper()->trim(),
            'city_id' => $request->city_id,
            'user_id' => $request->user_id
        ]);

        if (!$address) {
            $this->throwResponse('Something went Error while Creating Address');
        }

        return $this->jsonResponse('Success Create Address', $address, 201);
    }

    function update(UpdateAddressRequest $request)
    {
        $address = Address::find($request->id);

        $address->update([
            'address' => str($request->address)->title()->squish(),
            'postcode' => str($request->postcode)->upper()->trim(),
            'city_id' => $request->city_id,
            'user_id' => $request->user_id
        ]);

        if (!$address) {
            $this->throwResponse('Something went Error while Updating Address');
        }

        return $this->jsonResponse('Success Update Address', $address, 201);
    }

    function destroy(GetAddressRequest $request)
    {
        $address = Address::destroy($request->id);

        if (!$address) {
            $this->throwResponse('Something went Error while Deleting Address');
        }

        return $this->jsonResponse('Success Delete Address', $address, 201);
    }
}
