<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Traits\HasPusher;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Country\CountryResource;
use App\Http\Requests\Country\GetCountryRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryListResource;

class CountryController extends Controller
{
    use HasJsonResponse, HasPusher;

    function index()
    {
        $countries = CountryListResource::collection(Country::all());

        return $this->jsonResponse("Success", $countries);
    }

    function show(GetCountryRequest $request)
    {
        $country = new CountryResource(Country::find($request->id));

        return $this->jsonResponse("Success", $country);
    }

    function store(StoreCountryRequest $request)
    {
        $country = Country::create([
            "name" => str($request->name)->title()->squish(),
            "short_code" => str($request->short_code)->upper()->trim(),
            "long_code" => str($request->long_code)->upper()->trim(),
        ]);

        if (!$country) {
            $this->throwResponse("Something went Error while Creating Country");
        }

        // Nationality
        $country->nationality()->create(["name" => str($request->nationality_name)->ucfirst()->trim()]);
        // Phone
        $country->phone()->create(["code" => str($request->phone_code)->trim()]);
        // Currency
        $country->currency()->create([
            "name" => str($request->currency_name)->title()->squish(),
            "code" => str($request->currency_code)->upper()->trim()
        ]);

        return $this->jsonResponse("Success Create Country", $country, 201);
    }

    function update(UpdateCountryRequest $request)
    {
        $country = Country::find($request->id);

        $country->update([
            "name" => str($request->name)->title()->squish(),
            "short_code" => str($request->short_code)->upper()->trim(),
            "long_code" => str($request->long_code)->upper()->trim(),
        ]);

        if (!$country) {
            $this->throwResponse("Something went Error while Updating Country");
        }

        // Nationality
        $country->nationality->update(["name" => str($request->nationality_name)->ucfirst()->trim()]);
        // Phone
        $country->phone->update(["code" => str($request->phone_code)->trim()]);
        // Currency
        $country->currency->update([
            "name" => str($request->currency_name)->title()->squish(),
            "code" => str($request->currency_code)->upper()->trim()
        ]);

        return $this->jsonResponse("Success Update Country", $country, 201);
    }

    function destroy(GetCountryRequest $request)
    {
        $country = Country::destroy($request->id);

        if (!$country) {
            $this->throwResponse("Something went Error while Deleting Country");
        }

        return $this->jsonResponse("Success Delete Country", $country, 201);
    }
}
