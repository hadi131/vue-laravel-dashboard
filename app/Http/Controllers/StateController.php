<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Http\Resources\StateResource;
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
        $state = state::with(['country' => function ($query) {
            $query->addSelect(['id', 'name']);
        },]);
        $sortField = $req->sortField?? 'id';
        $sortDirection = $req->sortDirection?? 'asc';
        $Pagination = $req->Pagination;
        if ($Pagination) {


            $stateData = $state->orderBy($sortField, $sortDirection)->get();
            return StateResource::collection($stateData);
        }
        if ($search != '') {


            $stateData = $state->where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->paginate(4);
            return StateResource::collection($stateData);
        } elseif ($country_id != '') {


            $stateData = $state->orWhere('country_id', 'LIKE', "$country_id")->get();;
            return StateResource::collection($stateData);
        }
        else if ($sortField === 'country_name') {
            $stateData = $state->join('countries', 'states.country_id', '=', 'countries.id')
            ->orderBy('countries.name', $sortDirection)
            ->select('states.*');
        }
        else {

            $stateData = $state->orderBy($sortField, $sortDirection);
        }
        $stateData = $state->paginate(4)->appends([
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'search' => $search,
        ]);
        return StateResource::collection($stateData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StateRequest $request)
    {
        State::create([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);


        return response("status", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $State)
    {

        $stateData =  state::with('country')->find($State->id);
        return new StateResource($stateData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StateRequest $request, State $state)
    {

        $state->update([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);
        return response("status", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        if ($state->city()->count() > 0) {
            return response('Cannot delete city', 400);
        } else {

            $state->delete();
            return response("status", 204);
        }
    }
}
