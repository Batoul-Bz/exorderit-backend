<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PlanningController;
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
});

//|-------------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->get('/profile',[ProfileChefDController::class,'index']);


//|-------------------------------------------------------------------------------------------
