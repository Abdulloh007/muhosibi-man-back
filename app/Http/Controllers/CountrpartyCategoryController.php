<?php

namespace App\Http\Controllers;

use App\Models\CountrpartyCategory;
use Illuminate\Http\Request;

class CountrpartyCategoryController extends Controller
{
    public function index() {
        $categories = CountrpartyCategory::all();

        return response()->json($categories, 200);
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $category = CountrpartyCategory::create($validateData);

        return response()->json($category, 200);
    }

    
}
