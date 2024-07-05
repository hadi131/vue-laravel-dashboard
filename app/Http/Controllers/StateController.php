<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;
        $country_id = $req->country_id;
        $state = state::with('country');
        if ($search != '') {


            return $state->where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->get();;
        }
        elseif ($country_id != '') {


            return $state->orWhere('country_id', 'LIKE', "%$country_id%")->get();;
        }
        else {

           return $state->orderBy('id', 'DESC')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        State::create([
            'name' => $request->name,
            'country_id'=>$request->country_id
        ]);


        return response("status", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $State)
    {
        $stateData= state::with('country');
        return  $stateData->find($State);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state)
    {

        $state->update([
            'name' => $request->name,
            'country_id'=>$request->country_id
        ]);
        return response("status", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {


        $state->delete();
        return response("status", 204);
    }
}
