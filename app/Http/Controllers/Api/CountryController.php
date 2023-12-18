<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Models\Nationality;
use App\Http\Requests\PostCaller;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Resources\Country\CountryResource;
use App\Http\Requests\Country\GetCountryRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryListResource;
use App\Http\Resources\Country\CurrencyListResource;
use App\Http\Resources\Country\phoneCodeListResource;
use App\Http\Requests\Nationality\StoreNationalityRequest;

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

        (new PostCaller(
            NationalityController::class,
            "store",
            StoreNationalityRequest::class,
            [
                "name" => $request->nationality_name,
                "country_id" => $country->id,
            ]
        ))->call();

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
        $country = Country::destroy($request->id);

        if (!$country) {
            $this->throwResponse("Something went Error while Deleting Country");
        }

        return $this->jsonResponse("Success Delete Country", $country, 201);
    }
}
