<?php

namespace App\Http\Controllers;

use App\Models\Counterparty;
use App\Models\User;
use Illuminate\Http\Request;

class CounterpartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orgId = $request->user()->organizations[0]->id;
        $records = Counterparty::with(['category', 'payment_accounts'])->get()->where('organization_id', $orgId);

        return response()->json($records->values(), 200);
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
        $userId = $request->user()->id;
        $user = User::find($userId);
        
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'legal_address' => 'nullable|string|max:255',
            'physic_address' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer',
            'inn' => 'nullable',
            'kpp' => 'nullable',
            'contacts' => 'nullable|json',
            'for_sign_docs' => 'nullable',
            'by_person' => 'nullable',
            'passport_details' => 'nullable',
            'comment' => 'nullable',
            'payment_method' => 'nullable|string|max:50',
        ]);
        
        $validatedData['organization_id'] = $user->organizations[0]->id;
        $newRecord = Counterparty::create($validatedData);

        return response()->json(['data' => $newRecord], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $counterpartyId)
    {
        $counterparty = Counterparty::find($counterpartyId);

        if (!$counterparty) {
            return response()->json(
                [],
                404
            );
        }

        return response()->json(['data' => $counterparty], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Counterparty $counterparty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $record = Counterparty::find($id);

        if (!$record) {
            return response()->json(['message' => 'Counterparty not found'], 404);
        }

        // $validatedData = $request->validate([
        //     'full_name' => 'string|max:255',
        //     'short_name' => 'string|max:50',
        //     'legal_address' => 'string|max:255',
        //     'physic_address' => 'string|max:255',
        //     'site' => 'nullable|string|max:255',
        //     'inn' => 'integer',
        //     'kpp' => 'integer',
        //     'contacts' => 'nullable|json',
        //     'for_sign_docs' => 'nullable|json',
        //     'by_person' => 'nullable|json',
        //     'passport_details' => 'nullable|json',
        //     'comment' => 'nullable|json',
        //     'payment_method' => 'nullable|string|max:50',
        // ]);

        $record->update($request->all());

        return response()->json(['message' => 'Counterparty updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Counterparty::find($id);

        if (!$record) {
            return response()->json(['message' => 'Counterparty not found'], 404);
        }

        $record->delete();

        return response()->json(['message' => 'Counterparty deleted successfully'], 200);
    }
}
