<?php

namespace App\Http\Controllers;

use App\Models\DocGroup;
use Illuminate\Http\Request;
use App\Models\Documents;
use Auth;

class DocGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $organizations = $user->organizations()->get();
        $docgroup = [];
        foreach($organizations as $organization) {
            $documents = $organization->documents()->get();
            foreach($documents as $document) {
                $var = $document->docGroup()->first()->title;
                if(!in_array($var,$docgroup))
                    array_push($docgroup, $document->docGroup()->first()->title);
            }
        }
        return response()->json(['data'=> $docgroup]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocGroup $docGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocGroup $docGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocGroup $docGroup)
    {
        //
    }
}
