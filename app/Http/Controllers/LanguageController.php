<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $search = $req->search;
        $sortField = $req->sortField ?? 'id';
        $sortDirection = $req->sortDirection ?? 'asc';
        if ($search != '') {


            $languageData= Language::where('name', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->orWhere('code', 'LIKE', "%$search%")->paginate(4);

        }
        else {

            $languageData= Language::orderBy($sortField, $sortDirection)->paginate(4);

        }
        return LanguageResource::collection($languageData);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {
        Language::create([
            'name' => $request->name,
            'code' => $request->code
        ]);


        return response("status", 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        // if($language->translation()->count() > 0){
        //     return response('Cannot delete the Language', 400);
        //    }
        //    else{

               $language->delete();
               return response("status", 204);
            // }
    }
}
