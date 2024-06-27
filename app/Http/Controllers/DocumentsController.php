<?php

namespace App\Http\Controllers;

use App\Models\Documents;
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
        $documents = Documents::with(['documentType', 'docGroup'])->get()->where('organization_id', $orgId);

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
            'doc_typedoc_group_id' => 'required',
            'with_sign_seal' => 'boolean',
            'public' => 'boolean',
            'sum' => 'numeric',
            'products' => ''
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()], 400);
        }
        $input = $request->all();
        $input['organization_id'] = $user->organizations[0]->id;
        
        // Create a new document
        $document = Documents::create($input);

        if(isset($input['products'])) {
            
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
}
