<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;
        if ($search != '') {


            return Country::where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->get();;
        } else {

           return Country::orderBy('id', 'DESC')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {

        Country::create([
            'name' => $request->name,
        ]);


        return response("status", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return Country::find($country);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {

        $country->update([
            'name' => $request->name,
        ]);
        return response("status", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response("status", 204);
    }
}
