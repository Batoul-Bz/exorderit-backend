<?php

namespace App\Http\Controllers;
use App\Models\Planning;

use App\Models\HistoriqueM;

use Illuminate\Http\Request;

class PlanningController extends Controller
{
    
public function publish(Request $request, $id)
{
    if (!auth()->user()->is_admin) {
        return response()->json(['message' => 'Forbidden'], 403);
    }
    $plannings = Planning::where('statut', 'accepted')->get();
     if ($plannings->isEmpty()) {
        return response()->json([
            'message' => 'Aucun planning accepté à publier'
        ], 400);
    }

    foreach ($plannings as $planning) {
        $planning->update([
            'statut' => 'published',
            'action' => 'published',
        ]);

        PlanningHistorique::create([
            'planning_id' => $planning->id,
            'action' => 'published',
        ]);
    }

    return response()->json([
        'message' => 'Tous les plannings acceptés ont été publiés',
        'count' => $plannings->count()
    ]);
}

public function index(Request $request)
{
    $user = $request->user();      
    //$role = $user->role;           
    if(!$user){
        return response()->json(['message'=>'Not authenticated'],401);
    }
    if(!$user->role || $user->role !== 'admin'){
        return response()->json(['message'=>'Forbiden 1'],403);
    }
    $plannings = Planning::all();

    return response()->json($plannings);
}

public function accept(Planning $planning)
{
    $user=auth()->user();
    if (!$user || $user->role !== 'admin') {
       return response()->json(['message' => 'Forbidden 2',403]);
    
    }

    $planning->update([
        'statut' => 'accepted',
    ]);

    $planning->historiques()->create([
        'admin_id' => auth()->id(),
        'action' => 'accepted',
    ]);

    return redirect()->back()->with('success','Planning accepted successfuly');
}

public function refuse(Request $request, $id)
{
   
    try{
        $user=auth()->user();
        if (!$user || $user->role !== 'admin') {
       return response()->json(['message' => 'Forbidden 3',403]);
    
    }

    $request->validate([
        'comment' => 'required|string'
    ],['comment.required'=>'Le comment est requis']);

    $planning = Planning::findOrFail($id);

    $planning->update([
        'statut' => 'refused',
        //'action' => 'refused',
    ]);

    PlanningHistorique::create([
        'planning_id' => $planning->id,
        'admin_id'=> $user->id,
        'action' => 'refused',
        'comment' => $request->comment, 
        
    ]);

   return response()->json([
        'message' => 'Planning refusé',
        'planning' => $planning
    ]);
}catch (\Exception $e) {
        // هذا سيظهر لك الخطأ كـ JSON بدل HTML
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
   
}
}
