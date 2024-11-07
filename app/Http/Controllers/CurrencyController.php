<?php
namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::get();
        return response()->json($currencies); // Return all currencies as JSON
    }

    public function create()
    {
        return response()->json(['message' => 'Create new currency']); // You can replace with your logic
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sh_name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'well' => 'required|numeric', // 'well' should be numeric
        ]);

        $currency = Currency::create($request->all());

        return response()->json(['message' => 'Currency created successfully', 'currency' => $currency], 201);
    }

    public function show(Currency $currency)
    {
        return response()->json($currency); // Return single currency as JSON
    }

    public function edit(Currency $currency)
    {
        return response()->json($currency); // You can use this to show editable data
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sh_name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'well' => 'required|numeric', // 'well' should be numeric
        ]);

        $currency->update($request->all());

        return response()->json(['message' => 'Currency updated successfully', 'currency' => $currency]);
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response()->json(['message' => 'Currency deleted successfully']);
    }
}
