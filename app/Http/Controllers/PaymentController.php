<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orgId = $request->user()->organizations[0]->id;
        $payments = Payment::with('owner')->get()->where('organization_id', $orgId);
        return response()->json($payments->values());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $userId = $request->user()->id;
        $user = User::find($userId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $input = $request->all();
            $owner_id = $input['owner_id'];

            $fileContents = file_get_contents($file->getPathname());

            $json = json_decode($fileContents, true)['payments'];

            foreach ($json as $item) {
                foreach ($item as $key => $i) {
                    if (is_array($item[$key])) {
                        $item[$key] = json_encode($item[$key]);
                    }
                }
                $item['owner_id'] = $owner_id;
                $item['organization_id'] = $user->organizations[0]->id;
                $payment = Payment::create($item);
            }
            
            return response()->json(['status' => 'Successfully Saved !'], 200);
        } elseif ($request->input()) {
            $validator = Validator::make($request->all(), [
                'type_id' => 'required',
                'date' => 'required',
                'payment_sum' => 'required',
                'payment_purpose' => 'required',
                'comment' => 'nullable',
                'owner_id' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['validation' => $validator->errors()], 400);
            }
            
            $input = $request->input();
            $input['payer_account'] = $user->organizations[0]->counterparties[0]->payment_accounts[0]->id;
            $input['organization_id'] = $user->organizations[0]->id;

            $payment = Payment::create($input);
            return response()->json($payment, 200);
        } else {
            return response()->json(['error' => 'No file attached in the request'], 400);
        }
    }

    public function getPaymentsByOwnerId(Request $request, $owner_id)
    {
        $payments = Payment::where('owner_id', $owner_id)->get();

        if ($payments->isEmpty()) {
            return response()->json(['error' => 'No payments found for the provided owner_id'], 404);
        }

        foreach ($payments as $payment) {
            foreach ($payment->toArray() as $key => $value) {
                if (is_string($value) && is_array(json_decode($value, true))) {
                    $payment->$key = json_decode($value, true);
                }
                if (is_null($value)) {
                    unset($payment->$key);
                }
                unset($payment->id);
                unset($payment->owner_id);
                unset($payment->created_at);
                unset($payment->updated_at);
            }
        }

        $jsonContent = json_encode(['payments' => $payments], JSON_PRETTY_PRINT);

        $fileName = 'payments_' . $owner_id . '.json';
        $filePath = 'public/downloads/' . $fileName; // Adjust the storage path as needed
        Storage::put($filePath, $jsonContent);

        // Generate the file URL
        $fileUrl = Storage::url($filePath);

        // Return the file URL in the API response
        return response()->json(['file_url' => $fileUrl], 200);

        // return response()->json(['payments' => $payments], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'required|string',
            'date' => 'required|string',
            'number' => 'required|string|unique:payments',
            // Add validation rules for other fields here
        ]);

        $payment->update($validatedData);

        return response()->json($payment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully'], 200);
    }
}
