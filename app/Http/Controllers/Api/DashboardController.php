<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index(Request $request)
    {
        $user=$request->user();
        
        if(!$user){
            return response()->json(['message'=>'UnAuthorized']);
        }
       
        $data=[
            'message' => 'Welcome to dashboard',
        'user'=>[
            'name'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->role,
        ],
        ];
        return response()->json($data);
    }
}
