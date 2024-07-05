<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StateController;


Route::apiResource('/employee', EmployeeController::class);
Route::apiResource('/country', CountryController::class);
Route::apiResource('/city', CityController::class);
Route::apiResource('/state', StateController::class);

