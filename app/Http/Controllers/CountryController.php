<?php

namespace App\Http\Controllers;

// use App\Http\Requests\CountryRequest;

use App\Http\Requests\CountryRequest;

use App\Http\Resources\CountryResource;
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
        $Pagination = $req->Pagination;
        $sortField = $req->sortField;
        $sortDirection = $req->sortDirection;
        if ($Pagination) {


            $countryData= Country::orderBy($sortField, $sortDirection)->get();
            return CountryResource::collection($countryData);

        }
        if ($search != '') {


            $countryData= Country::where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->paginate(4);
            return CountryResource::collection($countryData);

        }
        else {

            $countryData= Country::orderBy($sortField, $sortDirection)->paginate(4);
            return CountryResource::collection($countryData);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
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

        // $countryData= Country::findOrFail($country->id);
        // return CountryResource::collection($countryData);
        return new CountryResource($country);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, Country $country)
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
       if($country->state()->count() > 0){
        return response('Cannot delete the Country', 400);
       }else{

           $country->delete();
           return response("status", 204);
        }
    }
}
