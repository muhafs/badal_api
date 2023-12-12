<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Resources\CountryListResource;
use App\Http\Resources\CurrencyListResource;
use App\Http\Resources\phoneCodeListResource;
use App\Http\Resources\NationalityListResource;

class CountryController extends Controller
{
    /*
    Todo:    - get country List
    Todo:    - get country detail
    Todo:    - create country
    Todo:    - update country
    Todo:    - delete country

    Todo:    - get nationality list
    Todo:    - get currency code list
    Todo:    - get phone code list
    */

    function index()
    {
        $countries = Country::all();

        return response()->json([
            'message' => 'Success',
            'data' => CountryListResource::collection($countries),
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
            ], 200);
        } else {
            return response()->json([
                'message' => 'Something went Error while Creating Country'
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
