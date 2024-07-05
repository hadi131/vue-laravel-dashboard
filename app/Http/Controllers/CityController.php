<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;
        $state_id = $req->state_id;

        $state = City::with('state');
        if ($search != '') {


            return $state->where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->get();;
        }
        elseif ($state_id != '') {


            return $state->orWhere('state_id', 'LIKE', "%$state_id%")->get();;
        }
        else {

           return $state->orderBy('id', 'DESC')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        City::create([
            'name' => $request->name,
            'state_id'=>$request->state_id
        ]);


        return response("status", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        $cityData= City::with('state');
        return $cityData->find($city);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update([
            'name' => $request->name,
            'state_id'=>$request->state_id
        ]);
        return response("status", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
         $city->delete();
        return response("status", 204);
    }
}
