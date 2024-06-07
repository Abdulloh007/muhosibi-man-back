<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string|max:5',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

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
            return response()->json(['validation' => $validator->errors()]);       
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
