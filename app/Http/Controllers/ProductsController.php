<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $orgId = $request->user()->organizations[0]->id;
        $products = Products::all()->where('organization_id', $orgId);

        return response()->json($products->values(), 200);
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::find($userId);
        
        $validatedData = $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string|max:5',
            'price' => 'required|numeric',
            'balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        
        $validatedData['organization_id'] = $user->organizations[0]->id;
        $product = Products::create($validatedData);
        return response()->json($product, 201);
    }

    public function show(Products $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Products $product)
    {

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'unit' => 'sometimes|string|max:5',
            'price' => 'sometimes|numeric',
            'description' => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json(['validation' => $validator->errors()], 400);       
        }
        

        $product->update($input);
        return response()->json($product);
    }

    public function destroy(Products $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
