<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
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
        $sortField = $req->sortField;
        $sortDirection = $req->sortDirection;
        $city = City::with([
            'state' => function ($query) {
                $query->addSelect(['id', 'name']);
            },
        ]);
        if ($search != '') {


            $cityData= $city->where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->paginate(4);
            return CityResource::collection($cityData);

        }
        elseif ($state_id != '') {


            $cityData=  $city->orWhere('state_id', 'LIKE', "$state_id")->get();
            return CityResource::collection($cityData);

        }
        else if ($sortField === 'state_name') {
            $cityData = $city->join('states', 'cities.state_id', '=', 'states.id')
            ->orderBy('states.name', $sortDirection)
            ->select('cities.*');
        }
        else {

           $cityData= $city->orderBy($sortField, $sortDirection);

        }
        $cityData = $city->paginate(4)->appends([
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'search' => $search,
        ]);
        return CityResource::collection($cityData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
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
        $cityData= City::with('state')->find($city->id);
        return new CityResource($cityData);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
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
        if($city->address()->count() > 0){
            return response('Cannot delete the City', 400);
           }else{

               $city->delete();
              return response("status", 204);
           }
    }
}
