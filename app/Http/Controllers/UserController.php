<?php

namespace App\Http\Controllers;

use App\Models\Cashbox;
use App\Models\Counterparty;
use App\Models\User;
use App\Models\Devices;
use App\Models\Documents;
use App\Models\Organization;
use App\Models\PaymentAccount;
use App\Models\Transactions;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(50);

        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
            'code_phrase' => 'nullable',
            'devices' => 'nullable',
            'device' => 'nullable',
            'status' => 'nullable',
            'name' => 'required',
            'surname' => 'required',
            'patronimic' => 'nullable',
            'gender' => 'nullable',
            'age' => 'nullable',
            'birth' => 'nullable',
            'tax_system' => 'required',
            'activity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()], 400);
        }

        $input = $request->all();

        $chekout = User::where('email', $input['email'])->orWhere('phone', $input['phone'])->first();

        if (is_null($chekout)) {
            $input['password'] = bcrypt($input['password']);
            if (isset($input['birth'])) {
                $input['birth'] = date('Y-m-d', strtotime($input['birth']));
            }

            $user = User::create($input);

            if (isset($input['device'])) {
                $device = json_decode($input['device']);
                $add_device['name'] = $device->name;
                if ($device->ip)
                    $add_device['ip'] = $device->ip;
                else
                    $add_device['ip'] = '192.168.1.1';
                $added_device = Devices::create($add_device);
                $user->devices()->sync($added_device->id);
            } else {
                $user->devices()->sync($input['devices']);
            }

            $organization = Organization::create([
                'title' => $input['name'] . " " . $input['surname'] . " " . $input['patronimic'],
                'tax_system' => $input['tax_system'],
                'type' => $input['activity'],
                'status' => 1,
                'owner_id' => $user->id
            ]);

            $counterparty = Counterparty::create([
                'full_name' => $input['name'] . " " . $input['surname'] . " " . $input['patronimic'],
                'organization_id' => $organization->id
            ]);

            $payment_account = PaymentAccount::create([
                'account' => '00000000000000000000',
                'bic' => '',
                'bank_name' => 'Основной',
                'owner_id' => $counterparty->id
            ]);

            $cashbox = Cashbox::create([
                'title' => 'Основная',
                'organization_id' => $organization->id
            ]);

            $success['username'] =  $user->username;
            $success['token'] =  $user->createToken('MuhosibiMan')->accessToken;
            $success['organizations'] =  $organization->id;
            $success['counterparty'] =  $counterparty->id;
            $success['payment_account'] =  $payment_account->id;
            $success['cashbox'] =  $cashbox->id;

            return response()->json($success, 200);
        } else {
            return response()->json(
                [
                    'status' => 'Duplicate (phone or email) user on register.'
                ],
                409
            );
        }
    }


    public function auth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'username' => 'required',
            // 'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => $validator->errors()], 400);
        }



        $input = $request->all();

        // $chekout = User::where('email',$input['email'])->first();
        // $chekout = User::where('username',$input['username'])->first();
        $chekout = User::where('phone', $input['phone'])->first();
        // $chekout = User::first();
        // if($chekout->phone==$input['phone'])
        // dd($chekout);


        if (!is_null($chekout)) {

            if (Hash::check($input['password'], $chekout->password)) {
                $user = $chekout;
                //$user->devices()->sync($request->devices);
                $success['id'] =  $user->id;
                $success['token'] =  $user->createToken('MuhosibiMan')->accessToken;
                $success['organizations'] = $user->organizations;
                $success['counterparty'] =  $user->organizations[0]->counterparties[0]->id;
                $success['payment_account'] =  $user->organizations[0]->counterparties[0]->payment_accounts[0]->id;
                $success['cashbox'] =  $user->organizations[0]->cashboxes[0]->id;
                $success['documents'] =  $user->organizations[0]->documents;

                return response()->json($success, 200);
            } else {
                return response()->json(
                    [
                        'status' => 'Password is incorrect.'
                    ],
                    401
                );
            }
        } else {
            return response()->json(
                [
                    'status' => 'User not found on auth.'
                ],
                404
            );
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(User $user)
    {
        $user = User::find($user);

        if (is_null($user)) {
            return response()->json(
                [
                    'status' => 'User not found on auth.'
                ],
                404
            );
        } else {
            $user['code_phrase'] = json_decode($user['code_phrase']);
            $user['devices'] = $user->devices;
        }

        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required',
        //     'email' => 'required|email',
        //     'phone' => 'required',
        //     'password' => 'nullable',
        //     'code_phrase' => 'required',
        //     'devices' => 'nullable',
        //     'device' => 'nullable',
        //     'status' => 'nullable'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['validation' => $validator->errors()]);
        // }

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $input = $request->all();

        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        if (isset($input['birth']))
            $input['birth'] = date('Y-m-d', strtotime($input['birth']));

        $user->update($input);

        if (isset($input['device'])) {
            $device = json_decode($input['device']);
            $add_device['name'] = $device->name;
            if ($device->ip)
                $add_device['ip'] = $device->ip;
            $added_device = Devices::create($add_device);

            $user->devices()->sync($added_device->id);
        } else {
            $user->devices()->sync($input['devices']);
        }

        return response()->json(['message' => 'User successfully updated'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $user = User::find($id);

            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }



    public function showMe(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::find($userId);

        if (is_null($user)) {
            return response()->json(
                [
                    'status' => 'User not found on auth.'
                ],
                404
            );
        } else {
            $user['code_phrase'] = json_decode($user['code_phrase']);
            $user['devices'] = $user->devices;
            $user['primary_organization'] = $user->organizations[0];
            $user['counterparties'] = $user->organizations[0]->counterparties;
            $user['payment_accounts'] = $user->organizations[0]->counterparties[0]->payment_accounts;
            $user['cashboxes'] = $user->organizations[0]->cashboxes;
            $user['documents'] =  Documents::with(['invoice', 'documentType', 'docGroup'])->get()->where('organization_id', $user->organizations[0]->id);
            
            $transactions = Transactions::with(['type',])->get()->where('organization_id', $user->organizations[0]->id);
            $incomes_total = 0;
            $outgoings_total = 0;
            foreach ($transactions as $transaction) {
                if($transaction->type->operation === 'income'){
                    $incomes_total = $incomes_total + $transaction->total;
                }elseif($transaction->type->operation === 'payment'){
                    $outgoings_total = $outgoings_total + $transaction->total;
                }
            }

            // Надо будет оптимизировать
            $user['incomes_total'] = $incomes_total;
            $user['outgoing_total'] = $outgoings_total;
        }

        return response()->json($user, 200);
    }
}
