<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//|-----------------------------------------------------------

Route::post('/login', [AuthController::class, 'login']);

//|--------------------------------------------------------------------------

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum','role:admin'])->get('/chef_departement/dashboard',function(){
        return response()->json(['message'=>'Welcome admin']);
    });

