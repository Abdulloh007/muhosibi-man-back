<?php

namespace App\Http\Controllers;

use App\Models\Counterparty;
use Illuminate\Http\Request;

class CounterpartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $input = $request->all();

        // $checkout = Counterparty::where('',$input['owner'])->first();

        // if(is_null($checkout)){
            $counterparty = Counterparty::create($input);
            return response()->json($counterparty);
        // }else{
        //     return response()->json(
        //         [ 
        //             'status' => 'This owner already has a payment account.'
        //         ],
        //         403
        //     );
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Counterparty $counterparty)
    {
        //
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
    public function update(Request $request, Counterparty $counterparty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Counterparty $counterparty)
    {
        //
    }
}
