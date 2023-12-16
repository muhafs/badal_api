<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Resources\Address\AddressResource;
use App\Http\Requests\Address\GetAddressRequest;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\Address\AddressListResource;

class AddressController extends Controller
{
    function index()
    {
        $addresses = Address::with('city', 'user')->get();

        return response()->json([
            'message' => 'Success',
            'data' => AddressListResource::collection($addresses)
        ], 200);
    }

    function show(GetAddressRequest $request)
    {
        $address = Address::with('city', 'user')->find($request->id);

        return response()->json([
            'message' => 'Success',
            'data' => new AddressResource($address)
        ], 200);
    }

    function store(StoreAddressRequest $request)
    {
        $address = Address::create([
            'address' => str($request->address)->title()->squish(),
            'postcode' => $request->postcode,
            'city_id' => $request->city_id
        ]);

        if ($address) {
            return response()->json([
                'message' => 'Success Create Address'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Creating Address'
            ], 400);
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
            return response()->json([
                'message' => 'Success Update Address'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Updating Address'
            ], 400);
        }
    }

    function destroy(GetAddressRequest $request)
    {
        $address = Address::find($request->id);

        $address->delete();

        if ($address) {
            return response()->json([
                'message' => 'Success Delete Address'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Deleting Address'
            ], 400);
        }
    }
}
