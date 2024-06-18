<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StuffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stuff = Stuff::paginate(50);

        return response()->json($stuff, 200);
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
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'father_name' => 'required|string',
            'birthday' => 'required|date',
            'gender' => 'required',
            'citizenship' => 'required|string',
            'contract_type' => 'required|string',
            'position' => 'required|string',
            'begin_date' => 'required|date',
            'experience_days' => 'required|integer',
            'unique_number' => 'required|string',
            'passport_details' => 'nullable|string',
            'legal_address' => 'required|string',
            'physic_address' => 'required|string',
            'inn' => 'required|string',
            'payment_method' => 'required|string',
            'organization_id' => 'required|integer',
        ]);

        // Create a new employee instance with the validated data
        $employee = Stuff::create($validatedData);

        // Return a response indicating success
        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $stuffId)
    {
        $stuff = Stuff::find($stuffId);

        if (!$stuff) {
            return response()->json(
                [
                    'message' => 'Stuff not found'
                ]
            );
        }

        return response()->json(
            [
                'data' => $stuff
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stuff $stuff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $stuff = Stuff::findOrFail($id);
        
        $stuff->update($request->all());

        return response()->json(['message' => 'Stuff updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stuff = Stuff::findOrFail($id);

        $stuff->delete();

        return response()->json(['message' => 'Stuff deleted successfully'], 200);
    }
}
