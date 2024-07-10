<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

// use App\Http\Controllers\StateController;

Route::apiResource('/employee', EmployeeController::class);
Route::apiResource('/country', CountryController::class);
Route::apiResource('/city', CityController::class);
Route::apiResource('/state', StateController::class);
Route::apiResource('/language', LanguageController::class);
// Route::get('/greeting/{locale}', function (string $locale) {
//     if (! in_array($locale, ['en', 'es', 'fr'])) {
//         abort(400);
//     }

//     App::setLocale($locale);

//     // ...
// });

Route::get('/translations/{locale}', function (string $locale) {
    if (!in_array($locale, ['en', 'ur'])) {
        abort(400, 'Invalid locale');
    }

    App::setLocale($locale);
    $translations = Lang::get('messages');

    return response()->json($translations);
});
