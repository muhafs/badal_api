<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Models\Nationality;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Country\CountryResource;
use App\Http\Requests\Country\GetCountryRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryListResource;
use App\Http\Resources\Country\CurrencyListResource;
use App\Http\Resources\Country\phoneCodeListResource;

class CountryController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $countries = CountryListResource::collection(Country::all());

        return $this->jsonResponse("Success", $countries);
    }

    function show(GetCountryRequest $request)
    {
        $country = new CountryResource(Country::with('nationality')->find($request->id));

        return $this->jsonResponse("Success", $country);
    }

    function store(StoreCountryRequest $request)
    {
        $country = Country::create([
            "name" => str($request->name)->title()->squish(),
            "currency_code" => str($request->currency_code)->upper()->trim(),
            "phone_code" => ($request->phone_code),
        ]);

        if (!$country) {
            $this->throwResponse("Something went Error while Creating Country");
        }

        $nationality = Nationality::create([
            "name" => str($request->nationality)->title()->squish(),
            "country_id" => $country->id
        ]);

        if (!$nationality) {
            $this->throwResponse("Something went Error while Creating Country's Nationality");
        }

        return $this->jsonResponse("Success Create Country", $country, 201);
    }

    function update(UpdateCountryRequest $request)
    {
        $country = Country::find($request->id);

        $country->update([
            "name" => str($request->name ?? $country->name)->title()->squish(),
            "currency_code" => str($request->currency_code ?? $country->currency_code)->upper()->trim(),
            "phone_code" => ($request->phone_code ?? $country->phone_code),
        ]);

        if (!$country) {
            $this->throwResponse("Something went Error while Updating Country");
        }

        return $this->jsonResponse("Success Update Country", $country, 201);
    }

    function destroy(GetCountryRequest $request)
    {
        $country = Country::find($request->id);

        $country->delete();

        if (!$country) {
            $this->throwResponse("Something went Error while Deleting Country");
        }

        return $this->jsonResponse("Success Delete Country", $country, 201);
    }

    function currencies()
    {
        $currencies = CurrencyListResource::collection(Country::all());

        return $this->jsonResponse("Success", $currencies);
    }

    function phoneCodes()
    {
        $phoneCodes = phoneCodeListResource::collection(Country::all());

        return $this->jsonResponse("Success", $phoneCodes);
    }
}
