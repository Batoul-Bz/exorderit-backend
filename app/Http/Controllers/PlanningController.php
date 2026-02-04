<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Planning;

use App\Models\HistoriqueM;

use Illuminate\Http\Request;

class PlanningController extends Controller
{
    
public function publish(Request $request)
{
    $user=auth()->user();
    if (!$user || $user->role !== 'admin') {
       return response()->json(['message' => 'Forbidden 2',403]);
    
    }

    $plannings = Planning::where('statut', 'accepted')->get();

     if ($plannings->isEmpty()) {
        return response()->json([
            'message' => 'Aucun planning accepté à publier'
        ], 400);
    }

    $user = User::whereIn('role',['teacher','student'])->get();

        Planning::where('statut','accepted')->update([
           'statut' => 'published',
        ]);

    //$plannings->historiques()->create([
     //       'admin_id' => auth()->id(),
      //     'planning_id' => $planning->id,
       //     'statut' => 'published',

       
       // ]);
       foreach ($plannings as $planning){
           $planning->historiques()->create([
            'admin_id' => auth()->id(),
            'planning_id' => $planning->id,
            'action'=>'published',
           ]);
        }
        
        foreach ($users as $user){
            $user->notify(new NewPlanningNotification($planning));
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
       return response()->json(['message' => 'Forbidden 2',403]);
    
    }

    $request->validate([
        'comment' => 'required|string'
    ],
    ['comment.required'=>'Le comment est requis']);

    $planning = Planning::findOrFail($id);

    $planning->update([
        'statut' => 'refused',
    ]);
    
     $planning->historiques()->create([
        'planning_id' => $planning->id,
        'admin_id' => auth()->id(),
        'action' => 'refused',
        'comment' => $request->comment,
    ]);

    $managers = User::where('role', 'responsable')->get(); 
        foreach ($managers as $manager) {
            $manager->notify(new PlanningRefusedNotification($planning, $request->comment));
        }

   return response()->json([
        'message' => 'Planning refusé',
        'planning' => $planning
    ]);
}catch (\Exception $e) {
        
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
   
}
}
