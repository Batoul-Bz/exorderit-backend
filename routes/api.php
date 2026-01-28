<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\AuthController;
//|-----------------------------------------------------------
Route::get('/health',function(){
    return "api is working";
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/plannings/{id}/publish', [PlanningController::class, 'publish']);
//|--------------------------------------------------------------------------

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/planning/{planning}/publish',[PlanningController::class,'publish']);

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class,'index']);

Route::middleware(['auth:sanctum','role:admin'])->get('/chef_departement/dashboard',function(){
        return response()->json(['message'=>'Welcome admin']);
    });

