<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Country\CountryResource;
use App\Http\Requests\Country\GetCountryRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryListResource;
use App\Http\Resources\Country\CurrencyListResource;
use App\Http\Resources\Country\phoneCodeListResource;
use App\Http\Resources\Country\NationalityListResource;

class CountryController extends Controller
{
    function index()
    {
        $countries = Country::all();

        return response()->json([
            'message' => 'Success',
            'data' => CountryListResource::collection($countries),
        ], 200);
    }

    function show(GetCountryRequest $request)
    {
        $country = Country::find($request->id);

        return response()->json([
            'message' => 'Success',
            'data' => new CountryResource($country),
        ], 200);
    }

    function store(StoreCountryRequest $request)
    {
        $country = Country::create([
            'name' => str($request->name)->title()->squish(),
            'nationality' => str($request->nationality)->title()->squish(),
            'currency_code' => str($request->currency_code)->upper()->trim(),
            'phone_code' => ($request->phone_code),
        ]);

        if ($country) {
            return response()->json([
                'message' => 'Success Create Country'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Creating Country'
            ], 400);
        }
    }

    function update(UpdateCountryRequest $request)
    {
        $country = Country::find($request->id);

        $country->update([
            'name' => str($request->name ?? $country->name)->title()->squish(),
            'nationality' => str($request->nationality ?? $country->nationality)->title()->squish(),
            'currency_code' => str($request->currency_code ?? $country->currency_code)->upper()->trim(),
            'phone_code' => ($request->phone_code ?? $country->phone_code),
        ]);

        if ($country) {
            return response()->json([
                'message' => 'Success Update Country'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Updating Country'
            ], 400);
        }
    }

    function destroy(GetCountryRequest $request)
    {
        $country = Country::find($request->id);

        $country->delete();

        if ($country) {
            return response()->json([
                'message' => 'Success Delete Country'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went Error while Deleting Country'
            ], 400);
        }
    }

    function nationalities()
    {
        $nationalities = NationalityListResource::collection(Country::all());

        return response()->json([
            'message' => 'Success',
            'data' => $nationalities,
        ], 200);
    }

    function currencies()
    {
        $currencies = CurrencyListResource::collection(Country::all());

        return response()->json([
            'message' => 'Success',
            'data' => $currencies,
        ], 200);
    }

    function phoneCodes()
    {
        $phoneCodes = phoneCodeListResource::collection(Country::all());

        return response()->json([
            'message' => 'Success',
            'data' => $phoneCodes,
        ], 200);
    }
}
