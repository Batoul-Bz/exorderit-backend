<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=>'Invalid credentials']);
        }
        $user=$request->user();
        $token=$user->createToken('api')->plainTextToken;

        return response()->json([
            'token'=>$token,
            'role'=>$user->role,
            'user'=>$user
        ])
    }
}
