<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' =>'required|string|min:3|max:255',
            'email' =>'required|string|email|min:3|max:50|unique:users',
            'password' =>'required|string|min:6|max:30|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json([
                'message'=>'User created successfull !',
                'status_code'=>200,
            ],200);
        } else {
            return response()->json([
                'message'=>'Some error occerred, Please try again.',
                'status_code'=>500,
            ],500);
        }        
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' =>'required|string|min:3|max:50',
            'password' =>'required|string|min:6',
            'remember_me'=>'boolean'
        ]);

        if (!Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
            ])) {
            return response()->json([
                'message'=>'Invalid username or password',
                'status_code'=>401
            ],401);
        }
        $user = $request->user();
        if ($user->role=='admin') {
            $tokenData = $user->createToken('Personal Access Token', ['admin']);
        }else{
            $tokenData = $user->createToken('Personal Author Token', ['user']);
        }

        $token = $tokenData->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        } 

        if ($token->save()) {
            return response()->json([
                'user'=>$user,
                'access_token' => $tokenData->accessToken,
                'token_type'=>'Bearer',
                'token_scope'=>$tokenData->token->scopes[0],
                'expires_at'=>Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code'=>200,
            ],200);
        } else {
            return response()->json([
                'message'=>'Some error occerred, Please try again.',
                'status_code'=>500,
            ],500);
        }      
        
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message'=>'Logout successfull !',
            'status_code'=>200
        ],200);
    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                $request->user(),
                200
            ]);
        }

        return response()->json([
            'message'=>'Not loggedin',
            'status_code'=>500,
        ],500);

    }


}