<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoices::paginate(25);
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator  = Validator::make($request->all(), [
            'product' => 'required|string|max:255',
            'count' => 'required|numeric',
            'unit' => 'required|string|max:5',
            'price' => 'required|numeric',
            'summary' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $invoice = Invoices::create($input);
        return response()->json($invoice, 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Invoices $invoice)
    {
        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Invoices $invoice)
    {
        $input = $request->all();

        $validator  = Validator::make($request->all(), [
            'product' => 'sometimes|string|max:255',
            'count' => 'sometimes|numeric',
            'unit' => 'sometimes|string|max:5',
            'price' => 'sometimes|numeric',
            'summary' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $invoice->update($input);
        return response()->json($invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Invoices $invoice)
    {
        $invoice->delete();
        return response()->json(null, 204);
    }
}
