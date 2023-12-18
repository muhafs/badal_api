<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasJsonResponse;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Resources\Currency\CurrencyResource;
use App\Http\Requests\Currency\GetCurrencyRequest;
use App\Http\Resources\Currency\CurrencyListResource;

class CurrencyController extends Controller
{
    use HasJsonResponse;

    function index()
    {
        $currencies = CurrencyListResource::collection(Currency::all());

        return $this->jsonResponse("Success", $currencies);
    }

    function show(GetCurrencyRequest $request)
    {
        $currency = new CurrencyResource(Currency::find($request->id));

        return $this->jsonResponse("Success", $currency);
    }

    function store(StoreCurrencyRequest $request)
    {
        $currency = Currency::create([
            "name" => str($request->name)->title()->squish(),
            "code" => str($request->code)->upper()->trim(),
            "country_id" => $request->country_id,
        ]);

        if (!$currency) {
            $this->throwResponse("Something went Error while Creating Currency");
        }

        return $this->jsonResponse("Success Create Currency", $currency, 201);
    }

    function update(UpdateCurrencyRequest $request)
    {
        $currency = Currency::find($request->id);

        $currency->update([
            "name" => str($request->name)->title()->squish(),
            "code" => str($request->code)->upper()->trim(),
            "country_id" => $request->country_id,
        ]);

        if (!$currency) {
            $this->throwResponse("Something went Error while Updating Currency");
        }

        return $this->jsonResponse("Success Update Currency", $currency, 201);
    }

    function destroy(GetCurrencyRequest $request)
    {
        $currency = Currency::destroy($request->id);

        if (!$currency) {
            $this->throwResponse("Something went Error while Deleting Currency");
        }

        return $this->jsonResponse("Success Delete Currency", $currency, 201);
    }
}
