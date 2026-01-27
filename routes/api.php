<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//|--------------------------------------------------------------------------
Route::get('/health', function () {
    return response()->json([
        'message' => 'API is working'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

//|--------------------------------------------------------------------------

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    Route::get('/admin/dashboard',function(){
        return response()->json(['message'=>'Welcome admin']);
    });
});
