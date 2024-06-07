<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $invoices = Invoices::with('document', 'products')->paginate(25);
        return response()->json($invoices);
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'document_id' => 'required|exists:documents,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.count' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $invoice = Invoices::create($input);

        foreach ($input['products'] as $product) {
            $invoice->products()->attach($product['product_id'], ['count' => $product['count']]);
        }

        return response()->json($invoice->load('products'), 201);
    }

    /**
     * Display the specified invoice.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Invoices $invoice)
    {
        $invoice->load('document', 'products');
        return response()->json($invoice);
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Invoices $invoice)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'document_id' => 'sometimes|exists:documents,id',
            'products' => 'sometimes|array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.count' => 'required_with:products|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $invoice->update($input);

        if (isset($input['products'])) {
            $invoice->products()->detach();
            foreach ($input['products'] as $product) {
                $invoice->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
            }
        }

        return response()->json($invoice->load('products'));
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoices  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Invoices $invoice)
    {
        $invoice->products()->detach();
        $invoice->delete();
        return response()->json(null, 204);
    }
}
