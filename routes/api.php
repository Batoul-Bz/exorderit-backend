<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\AuthController;
//|-----------------------------------------------------------
Route::get('/health',function(){
    return "api is working";
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/plannings/published',function(){
    return Planning::where('statut','published')->get();
});

//|--------------------------------------------------------------------------

Route::middleware('auth:sanctum')->group( function () {
   Route::post('/plannings/{id}/accept', [PlanningController::class, 'accept']);
Route::post('/plannings/{id}/refuse', [PlanningController::class, 'refuse']);
});

Route::middleware('auth:sanctum')->post('/plannings/publish',[PlanningController::class,'publish']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class,'index']);

Route::middleware(['auth:sanctum','role:admin'])->get('/chef_departement/dashboard',function(){
        return response()->json(['message'=>'Welcome admin']);
    });

