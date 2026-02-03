<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
//use App\Http\Controllers;

use App\Http\Controllers\PlanningController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProfileChefDController;


//|-----------------------------------------------------------

Route::post('/login', [AuthController::class, 'login']);


//Route::middleware('auth:sanctum')->Route::post('/login', [AuthController::class, 'logut']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum','role:admin'])->get('/chef_departement/dashboard',function(){
        return response()->json(['message'=>'Welcome admin']);
    });


//|-------------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class,'index']);

//|-------------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->group( function () {
   Route::get('/plannings',[PlanningController::class,'index']);

   Route::post('/plannings',function () {
    return Planning::all();});

   Route::post('/plannings/{planning}/accept', [PlanningController::class, 'accept']);
   
   Route::post('/plannings/{planning}/refuse', [PlanningController::class, 'refuse']);

    Route::post('/plannings/publish', [PlanningController::class, 'publish']);
});

//|-------------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->get('/profile',[ProfileChefDController::class,'index']);


//|-------------------------------------------------------------------------------------------
 
Route::middleware('auth:sanctum')->get('/notification',function(Request $request){
    return response()->json([
        'notification'=>$request->user()->unreadNotifications
    ]);
});

Route::middleware('auth:sanctum')->get('/notification/read',function(Request $request){
    $request->user()->unreadNotifications->markAsRead();
    return response()->json(['statut'=>'ok'
    ]);
});