<?php

namespace App\Http\Controllers;

use App\Models\DocGroup;
use App\Models\Documents;
use App\Models\DocumentsType;
use App\Models\Invoices;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orgId = $request->user()->organizations[0]->id;
        $documents = Documents::with(['documentType', 'docGroup', 'counterparty'])->get()->where('organization_id', $orgId);

        // Optionally, you can return a JSON response with the retrieved documents
        return response()->json($documents, 200);
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
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'template' => 'required|string',
            'status' => 'required|string',
            'counterparty_id' => 'required|integer',
            'metatag' => 'nullable|json',
            'doc_type' => 'required',
            'doc_group_id' => 'nullable',
            'with_sign_seal' => 'boolean',
            'public' => 'boolean',
            'sum' => 'numeric',
            'products' => 'nullable'
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()], 400);
        }
        $input = $request->all();
        $input['organization_id'] = $user->organizations[0]->id;
        $doc_type = DocumentsType::find($input['doc_type']);

        if (isset($input["group"])) {
            $docGroup = DocGroup::create(["title" => $input["group"]]);
            $input["doc_group_id"] = $docGroup->id;
        }

        // dd($input);
        // Create a new document
        $document = Documents::create($input);

        if (isset($input['products'])) {
            $invoice = Invoices::create([
                'document_id' => $document->id,
                'summary' => $document->sum,
                'sale' => 0,
                'organization_id' => $user->organizations[0]->id,
            ]);

            foreach ($input['products'] as $product) {
                if ($product['product_id'] != 0) {
                    $invoice->products()->attach($product['product_id'], ['count' => $product['count'], 'price' => $product['price']]);
                    $productDB = Products::find($product['product_id']);
                    if (isset($productDB)) {
                        if ($doc_type->type === 'income') {
                            $productDB->update(["balance" => $productDB["balance"] + $product['count']]);
                        } else {
                            $productDB->update(["balance" => $productDB["balance"] - $product['count']]);
                        }
                    }
                }
            }
        }

        // Return a JSON response with the created document
        return response()->json($document, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $documentId)
    {
        $documents = Documents::find($documentId);

        if (!$documents) {
            return response()->json(
                [
                    'message' => "Document not found"
                ],
                404
            );
        }

        return response()->json(
            [
                'data' => $documents
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documents $documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'template' => 'string',
            'metatag' => 'nullable|json',
            'with_sign_seal' => 'boolean',
            'public' => 'boolean',
            'sum' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()]);
        }

        // Find the document by ID
        $document = Documents::find($id);

        // Check if the document exists
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Update the document with the validated data
        $document->update($request->all());

        // Optionally, you can return a response with the updated document
        return response()->json(['message' => 'Document updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the document by ID
        $document = Documents::find($id);

        // Check if the document exists
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Delete the document
        $document->delete();

        // Optionally, you can return a response with a success message
        return response()->json(['message' => 'Document deleted successfully'], 200);
    }

    public function getDocs4Transaction(Request $request, $counterparty)
    {
        $orgId = $request->user()->organizations[0]->id;
        $documents = Documents::with(['documentType', 'docGroup', 'counterparty'])->get()->where('organization_id', $orgId)->where('counterparty_id', $counterparty);

        // Optionally, you can return a JSON response with the retrieved documents
        return response()->json($documents->values(), 200);
    }
}
