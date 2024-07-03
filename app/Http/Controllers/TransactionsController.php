<?php

namespace App\Http\Controllers;

use App\Models\Cashbox;
use App\Models\PaymentAccount;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $orgId = $request->user()->organizations[0]->id;
        $transactions = Transactions::with(['type', 'counterparty'])->get()->where('organization_id', $orgId);
        return response()->json($transactions, 200);
    }

    public function show($id)
    {
        $transaction = Transactions::with(['sender', 'taker', 'paymentAccount'])->find($id);

        if (is_null($transaction)) {
            return response()->json(
                [
                    'status' => 'Transaction not found.'
                ],
                404
            );
        }

        return response()->json($transaction);
    }



    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::find($userId);
        
        $validator = Validator::make($request->all(), [
            'operation' => 'required',
            'type_id' => 'required',
            'doctype_id' => 'nullable',
            'document_id' => 'nullable',
            'resource' => 'required',
            'title' => 'nullable',
            'details' => 'nullable',
            'date' => 'required',
            'total' => 'required',
            'total_tax' => 'required',
            'payment_account' => 'required',
            'counterparty_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()], 400);
        }

        $input = $request->all();
        $input['organization_id'] = $user->organizations[0]->id;
        
        $transaction = Transactions::create($input);

        if ($input['resource'] == 'bank' || $input['resource'] == 'ect') {
            $payment_account = PaymentAccount::find($input['payment_account']);
        }elseif ($input['resource'] == 'cash') {
            $payment_account = $user->organizations[0]->cashboxes[0];
        }
        if ($input['operation'] == 'income') $payment_account->balance += $input['total'];
        elseif ($input['operation'] == 'payment') $payment_account->balance -= $input['total'];
        
        $payment_account->save();

        return response()->json($transaction, 201);
    }



    public function update(Request $request, $id)
    {
        $transaction = Transactions::find($id);

        if (is_null($transaction)) {
            return response()->json(['error' => 'Transactions not found'], 404);
        }

        $input = $request->all();

        $transaction->update($input);

        return response()->json($transaction, 200);
    }

    public function destroy($id)
    {
        $transaction = Transactions::findOrFail($id);

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }
}
