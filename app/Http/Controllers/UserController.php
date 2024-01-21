<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

/**
 * @OA\Info(
 *    title="User API's",
 *    version="1.0.0",
 * )
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     * path="/api/register",
     * summary="User Registration",
     * description="Register by ...",
     * operationId="registerUser",
     * tags={"user"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"username","email","password","phone","code_phrase"},
     *       @OA\Property(property="username", type="string", format="text", example="Username"),
     *       @OA\Property(property="email", type="string", format="email", example="email@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="phone", type="string", example="992999999999"),
     *       @OA\Property(property="code_phrase", type="string", format="text", example="ih"),
     *       @OA\Property(
     *                property="devices",
     *                description="Devices of user form Devices table",
     *                type="array",
     *                collectionFormat="multi",
     *            @OA\Items(type="integer", format="id",),
     *            example="[1,2]"
     *       ),
     *       @OA\Property(property="status", type="string", format="text", example="2"),
     *    ),
     * ),
     * @OA\Response(
     *    response=409,
     *    description="User already exist",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="Duplicate (phone or email) user on register."),
     *    )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Correct Registration",
     *    @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2Q5MTkxYmE3OWNmYzM3MzcyMWIzNmFlOWJlMTRkMTljYjc2YWRhZGQ0NDA3MzIxNzczMzRkYmY1OTc3MWUwODc0OWNmZWJkNjBjNThjZjQiLCJpYXQiOjE3MDU2ODc2OTcuOTAwMDg3LCJuYmYiOjE3MDU2ODc2OTcuOTAwMDksImV4cCI6MTczNzMxMDA5Ny44ODY2NjEsInN1YiI6IjQiLCJzY29wZXMiOltdfQ.Qrf05e_exPvESGJIeSuOpF56kH7drJsd9L3ZymFkyi68ZOoCFvqesRU505p10JUwNQ14dyrlOPpjq85sk6AdEVHT0vaO2WRspaHVrF3ZPSyNH3VpuVRfs12lGNlFaOMTzR1O1qb2PLL306KrltPfwDa1G42GH6Sl_ji2Aiu-2-Rsc0ap6dgFSI5GmiwO92ErE_nMgMjfNwvmw3CgPPWhs934WcZaBHjAYU5csbYoNxq8SsQ5IxCcWyhoj4Tm2D-hbhEtOccYAmG71Cen_z8DOf2Zso20eDKWBZdNynWvpKXyHJYh1wyB2aBQKcHqDMa-dvoQg5_i1-Z7AELG-C1GkqiTo7qPwT5npJz8kpmIhlM9vkh3HelWHajkcbWDw1HZV--wFZJEdAuBlA7j9YffFsVmF1rmyxbA6fNGKCpqaLYEqDXNo_nMkI9NcP_Rwcd5TFSACXw17xqPVzZndmyar06r2ytYHSXPmUorq7xzYVYg1087KS2y6ZQQ2KUkcQlL4qKzHJS2gU-xQUe3gQEzN2cb6-PBbM-w99o2qaH-z4oR8NTY481NXGfEQFLPAxwGkONak1JYVewlqztltenqT2wfzcYwVaokQ7CIbgKHRuhyyWkkFqf9q1Lnkc3CwtoMmSb7RXs5bq2Ia3obGx6cKOgOpvGlM6zo0eC7FDsFa5s"),
     *       @OA\Property(property="name", type="string", example="Name"),
     *      )
     *     )
     * ),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'phone'=>'required',
            'password' => 'required',
            'code_phrase' => 'required',
            'devices' => 'nullable',
            'status'=>'nullable'
        ]);

        if($validator->fails()){
            return response()->json(['validation' => $validator->errors()]);       
        }

        

        $input = $request->all();
        
        $chekout = User::where('email',$input['email'])->orWhere('phone', $input['phone'])->first();
        if(is_null($chekout)){

            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user->devices()->sync($request->devices);
            $success['token'] =  $user->createToken('MuhosibiMan')->accessToken;
            $success['username'] =  $user->username;

            return response()->json($success,200);

        }else{
            return response()->json(
                [ 
                    'status' => 'Duplicate (phone or email) user on register.'
                ],
                409
            );
        }


    }


    public function auth(Request $request){

        $validator = Validator::make($request->all(), [
            // 'username' => 'required',
            // 'email' => 'required|email',
            'phone'=>'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation' => $validator->errors()]);       
        }

        

        $input = $request->all();
        
        // $chekout = User::where('email',$input['email'])->first();
        // $chekout = User::where('username',$input['username'])->first();
        $chekout = User::where('phone',$input['phone'])->first();
        if(!is_null($chekout)){

            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user->devices()->sync($request->devices);
            $success['token'] =  $user->createToken('MuhosibiMan')->accessToken;
            $success['username'] =  $user->username;

            return response()->json($success,200);

        }else{
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

        if(is_null($user)){
            return response()->json(
                [ 
                    'status' => 'User not found on auth.'
                ],
                404
            );
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
