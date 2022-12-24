<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
        function create_user(Request $request)
        {
            try
            {
                $validateUser= Validator::make($request->all(),
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8',],
                        'phone_number' => ['required', 'numeric',],
                    ]);
                if($validateUser->fails()) {
                    return response()->json([
                        'status'=>false,
                        'message'=>'validation error',
                        ''=>$validateUser->errors(),
                    ],401);
                }
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number'=>$request->phone_number,
                    'is_user'=>1,
                    ]);
                return response()->json([
                    'status'=>true,
                    'message'=>'User created successfully',
                    'token'=>$user->createToken('Api Token')->plainTextToken,
                ],200);
            }
            catch(\Throwable $th) {
                return response()->json([
                   'status'=>false,
                   'message'=>$th->getMessage()
                ],500);
            }
    }
    /*
     function create_expert(Request $request)
        {
            try
            {
                $validateExpert= Validator::make($request->all(),
                    [
                        'name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8',],
                        'phone_number' => ['required', 'numeric',],
                        'address'=>['string','max:255']
                    ]);
                if($validateUser->fails()) {
                    return response()->json([
                        'status'=>false,
                        'message'=>'validation error',
                        ''=>$validateUser->errors(),
                    ],401);
                }
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number'=>$request->phone_number,
                    'is_user'=>1,
                    ]);
                return response()->json([
                    'status'=>true,
                    'message'=>'User created successfully',
                    'token'=>$user->createToken('Api Token')->plainTextToken,
                ],200);
            }
            catch(\Throwable $th) {
                return response()->json([
                   'status'=>false,
                   'message'=>$th->getMessage()
                ],500);
            }
    }
     */
    /*function get_user(Request $request)
    {
        return $request->user();
    }*/
    function login(Request $request)
    {
        try {
            $validateUser= Validator::make($request->all(),
                [
                    'email' => ['required' , 'email'],
                    'password' => ['required', 'string', 'min:8',],
                ]);
            if($validateUser->fails()) {
                return response()->json([
                    'status'=>false,
                    'message'=>'validation error',
                    ''=>$validateUser->errors(),
                ],401);
            }
            if(!Auth::attempt($request->only(['email','password'])))
            {
                return response()->json([
                    'status'=>false,
                    'message'=>'email or password does not match ,',
                    ''=>$validateUser->errors(),
                ],401);
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
               'status'=>true,
                'token'=>$user->createToken('Api Token')->plainTextToken,
                'type'=>$user->is_user,
            ],200);
        }
        catch(\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],500);
        }
    }
    function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return 'logout  successfully';
    }
}
