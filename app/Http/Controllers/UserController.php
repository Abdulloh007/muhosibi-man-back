<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Devices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
        $users = User::paginate(50);

        return response()->json($users,200);

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
            'device' => 'nullable',
            'status'=>'nullable',
            'name'=>'required',
            'surname'=>'required',
            'patronimic'=>'required',
            'gender'=>'required',
            'age'=>'required',
            'birth'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation' => $validator->errors()]);       
        }
        
        $input = $request->all();
        
        $chekout = User::where('email',$input['email'])->orWhere('phone', $input['phone'])->first();
        if(is_null($chekout)){
            $input['password'] = bcrypt($input['password']);
            $input['birth'] = date('Y-m-d',strtotime($input['birth']));
            $user = User::create($input);

            if(isset($input['device'])){
                $device = json_decode($input['device']);
                $add_device['name'] = $device->name;
                if($device->ip)
                    $add_device['ip'] = $device->ip;
                $added_device = Devices::create($add_device);
            
                $user->devices()->sync($added_device->id);
            }else{
                $user->devices()->sync($input['devices']);
            }


            $success['username'] =  $user->username;
            $success['token'] =  $user->createToken('MuhosibiMan')->accessToken;

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

    /**
     * @OA\Post(
     * path="/api/auth",
     * summary="User Authorization",
     * description="Auth by ...",
     * operationId="authUser",
     * tags={"user"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="phone", type="string", example="992999999999"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=404,
     *    description="User not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="User not found on auth."),
     *    )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Password is incorrect",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="Password is incorrect."),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Signed in",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="string", example="1"),
     *       @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2Q5MTkxYmE3OWNmYzM3MzcyMWIzNmFlOWJlMTRkMTljYjc2YWRhZGQ0NDA3MzIxNzczMzRkYmY1OTc3MWUwODc0OWNmZWJkNjBjNThjZjQiLCJpYXQiOjE3MDU2ODc2OTcuOTAwMDg3LCJuYmYiOjE3MDU2ODc2OTcuOTAwMDksImV4cCI6MTczNzMxMDA5Ny44ODY2NjEsInN1YiI6IjQiLCJzY29wZXMiOltdfQ.Qrf05e_exPvESGJIeSuOpF56kH7drJsd9L3ZymFkyi68ZOoCFvqesRU505p10JUwNQ14dyrlOPpjq85sk6AdEVHT0vaO2WRspaHVrF3ZPSyNH3VpuVRfs12lGNlFaOMTzR1O1qb2PLL306KrltPfwDa1G42GH6Sl_ji2Aiu-2-Rsc0ap6dgFSI5GmiwO92ErE_nMgMjfNwvmw3CgPPWhs934WcZaBHjAYU5csbYoNxq8SsQ5IxCcWyhoj4Tm2D-hbhEtOccYAmG71Cen_z8DOf2Zso20eDKWBZdNynWvpKXyHJYh1wyB2aBQKcHqDMa-dvoQg5_i1-Z7AELG-C1GkqiTo7qPwT5npJz8kpmIhlM9vkh3HelWHajkcbWDw1HZV--wFZJEdAuBlA7j9YffFsVmF1rmyxbA6fNGKCpqaLYEqDXNo_nMkI9NcP_Rwcd5TFSACXw17xqPVzZndmyar06r2ytYHSXPmUorq7xzYVYg1087KS2y6ZQQ2KUkcQlL4qKzHJS2gU-xQUe3gQEzN2cb6-PBbM-w99o2qaH-z4oR8NTY481NXGfEQFLPAxwGkONak1JYVewlqztltenqT2wfzcYwVaokQ7CIbgKHRuhyyWkkFqf9q1Lnkc3CwtoMmSb7RXs5bq2Ia3obGx6cKOgOpvGlM6zo0eC7FDsFa5s"),
     *      )
     *     )
     * ),
     * )
     */
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
        $chekout = User::where('phone', $input['phone'])->first();
        // $chekout = User::first();
        // if($chekout->phone==$input['phone'])
            // dd($chekout);
        
        
        if(!is_null($chekout)){

            if(Hash::check($input['password'], $chekout->password)){
                $user = $chekout;

                 //$user->devices()->sync($request->devices);
                $success['id'] =  $user->id;
                $success['token'] =  $user->createToken('MuhosibiMan')->accessToken;

                return response()->json($success,200);

            }else{
                return response()->json(
                    [ 
                        'status' => 'Password is incorrect.'
                    ],
                    401
                );
            }

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
    /**
     * @OA\GET(
     *     path="/api/user/{id}",
     *     summary="Get User",
     *     description="Get User by Id",
     *     operationId="getUser",
     *     tags={"user"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="User identifier",
     *         required=true,
     *         example="12"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="User not found on auth.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User founded",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example="12"),
     *             @OA\Property(property="username", type="string", example="Abdurazzoq"),
     *             @OA\Property(property="email", type="string", example="abdurazzoq9050@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="992928369050"),
     *             @OA\Property(
     *                 property="code_phrase",
     *                 description="Code Phrases",
     *                 type="array",
     *                 @OA\Items(type="string", format="id"),
     *                 example="['ih', 'liebe', 'dich']"
     *             ),
     *             @OA\Property(property="status", type="string", example="active"),
     *             @OA\Property(property="created_at", type="string", example="2024-01-21T09:09:38.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-01-21T09:09:38.000000Z"),
     *             @OA\Property(
     *                 property="devices",
     *                 description="List of devices",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example="1"),
     *                     @OA\Property(property="name", type="string", example="Poco M3"),
     *                     @OA\Property(property="ip", type="string", example="192.168.1.100"),
     *                     @OA\Property(property="location", type="string", example=null),
     *                     @OA\Property(property="created_at", type="string", example="2024-01-21T08:39:46.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2024-01-21T08:39:46.000000Z"),
     *                 )
     *             ),
     *         )
     *     )
     * )
     */
    public function show(User $user)
    {
        $user = User::find($user)->first();

        if(is_null($user)){
            return response()->json(
                [ 
                    'status' => 'User not found on auth.'
                ],
                404
            );
        }else{
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
        
        if(isset($input['birth']))
            $input['birth'] = date('Y-m-d',strtotime($input['birth']));
    
        $user->update($input);
    
        if(isset($input['device'])){
            $device = json_decode($input['device']);
            $add_device['name'] = $device->name;
            if($device->ip)
                $add_device['ip'] = $device->ip;
            $added_device = Devices::create($add_device);
        
            $user->devices()->sync($added_device->id);
        }else{
            $user->devices()->sync($input['devices']);
        }
    
        return response()->json(['message'=>'User successfully updated'], 200);
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
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }

    

    public function showMe(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::find($userId)->first();

        if(is_null($user)){
            return response()->json(
                [ 
                    'status' => 'User not found on auth.'
                ],
                404
            );
        }else{
            $user['code_phrase'] = json_decode($user['code_phrase']);
            $user['devices'] = $user->devices;
        }

        return response()->json($user, 200);
    }

}
