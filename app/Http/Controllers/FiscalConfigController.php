<?php

namespace App\Http\Controllers;

use App\Models\FiscalConfig;
use App\Models\Organization;
use Illuminate\Http\Request;

class FiscalConfigController extends Controller
{
    /**
     * Display a listing of the fiscal configurations for a specific organization.
     */
    public function index(Organization $organization)
    {
        $fiscalConfigs = $organization->fiscalConfigs;
        return response()->json($fiscalConfigs);
    }

    /**
     * Store a newly created fiscal configuration for a specific organization.
     */
    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'server' => 'required|string',
            'port' => 'required|string',
        ]);

        $fiscalConfig = $organization->fiscalConfigs()->create($request->only(['server', 'port']));
        return response()->json($fiscalConfig, 201);
    }

    /**
     * Display the specified fiscal configuration.
     */
    public function show(FiscalConfig $fiscalConfig)
    {
        return response()->json($fiscalConfig);
    }

    /**
     * Update the specified fiscal configuration.
     */
    public function update(Request $request, FiscalConfig $fiscalConfig)
    {
        $request->validate([
            'server' => 'sometimes|required|string',
            'port' => 'sometimes|required|string',
        ]);

        $fiscalConfig->update($request->only(['server', 'port']));
        return response()->json($fiscalConfig);
    }

    /**
     * Remove the specified fiscal configuration.
     */
    public function destroy(FiscalConfig $fiscalConfig)
    {
        $fiscalConfig->delete();
        return response()->json(['message' => 'Fiscal configuration deleted successfully']);
    }
}
