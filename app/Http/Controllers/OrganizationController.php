<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\Organization;
use Illuminate\Http\Request;
use Validator;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all organizations from the 'organizations' table
        $organizations = Organization::all();

        // Optionally, you can return a JSON response with the retrieved organizations
        return response()->json(['data' => $organizations], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'inn' => 'nullable',
            'kpp' => 'nullable',
            'tax_system' => 'required',
            'legal_address' => 'nullable',
            'physic_address' => 'nullable',
            'type' => 'required',
            'contacts' => 'nullable',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()]);
        }

        $input = $request->all();

        $organization = Organization::create($input);

        if (is_string($input['activities']) && strpos($input['activities'], ',') !== false) {
            $arr = explode(',', $input['activities']);
            foreach ($arr as $item) {
                // $organization->activities()->sync($item);
                $organization->activities()->attach($item);
            }
        } else {
            $organization->activities()->sync($input['activities']);
        }

        return response()->json($organization, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $organizationId)
    {
        $organization = Organization::find($organizationId);

        if ($organization->currency) {
            $organization->currency_name = $organization->currency->name;
        } else {
            $organization->currency = false;
            $organization->currency_name = "Валюта не установлена";
        }

        if (is_null($organization)) {
            return response()->json(
                [
                    'message' => 'Organization not found'
                ],
                404
            );
        } else {
            return response()->json(
                [
                    'data' => $organization
                ],
                200
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make([
            'title' => 'string|max:255',
            'inn' => 'nullable|string|max:12',
            'kpp' => 'nullable|string|max:9',
            'tax_system' => 'nullable|string|max:255',
            'legal_address' => 'nullable|string',
            'physic_address' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'contacts' => 'nullable|json',
            'status' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()]);
        }

        $organization = Organization::find($id);

        if (!$organization) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        if ($organization->status === 'active') {
            $organization->update($request->all());

            return response()->json(['message' => 'Organization updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Organization cannot be updated due to a specific condition'], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (!$organization) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        $organization->delete();

        return response()->json(['message' => 'Organization deleted successfully'], 200);
    }


    public function getOrgStauff(int $organizationId)
    {
        $organization = Organization::find($organizationId);
        $orgStuff = $organization->stuff;

        // return response()->json(
        //     [
        //         'message' => 'Organization not found'
        //     ], 404
        // );

        return response()->json(
            [
                'data' => $orgStuff
            ],
            200
        );
    }
}
