<?php

// use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
// Route::get("locale/{lange}",LocalizationController::class,"setLang");
