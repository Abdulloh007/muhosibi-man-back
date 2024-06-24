<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    public function index()
    {
        $typesList = TransactionType::all();

        return response()->json($typesList);
    }
}
