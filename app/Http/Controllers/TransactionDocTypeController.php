<?php

namespace App\Http\Controllers;

use App\Models\TransactionDocType;
use Illuminate\Http\Request;

class TransactionDocTypeController extends Controller
{
    public function index()
    {
        $docTypes = TransactionDocType::all();

        return response()->json($docTypes, 200);
    }
}
