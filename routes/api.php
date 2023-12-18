<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PhoneController;
use App\Http\Controllers\Api\SeekerController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\PerformerController;
use App\Http\Controllers\Api\NationalityController;

Route::get('test', function () {
    //
});

Route::apiResource('country', CountryController::class);

Route::apiResource('nationality', NationalityController::class);

Route::apiResource('phone', PhoneController::class);

Route::apiResource('currency', CurrencyController::class);

Route::apiResource('province', ProvinceController::class);

Route::apiResource('city', CityController::class);

Route::apiResource('address', AddressController::class);

Route::apiResource('user', UserController::class);

Route::apiResource('contact', ContactController::class);

Route::apiResource('seeker', SeekerController::class);

Route::apiResource('performer', PerformerController::class);
