<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanningController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'niveau' => 'required|string',
            'groupe' => 'required|string',
            'enseignant' => 'required|string',
            'module' => 'required|string',
            'jour' => 'required|string',
            'heure' => 'required|string',
            'salle' => 'required|string',
            'statut' => 'nullable|in:draft,published',
            'action' => 'nullable|string',
        ]);
        //example pour affi
    $planning = Planning::create([
    'niveau' => '1ère',
    'groupe' => 'A',
    'enseignant' => 'Mme. Sara',
    'module' => 'Math',
    'jour' => 'Lundi',
    'heure' => '08:00',
    'salle' => '101',
    'statut' => 'draft',// c'est q dire en attente
    'action' => 'Voir les documents',
    'visible_to' => ['admin']//permission just pour admin c'est just example pour debut
]);
   
    return response()->json($planning);
    }

     public function index(Request $request)
{
    $user = $request->user();      
    $role = $user->role;           

    $plannings = Planning::whereJsonContains('visible_to', $role)->get();

    return response()->json($plannings);
}

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

public function accept($id)
{
    
    if (!auth()->user()->is_admin) {
       return response()->json(['message' => 'Forbidden'], 403);
    
    }

    $planning = Planning::findOrFail($id);

    $planning->update([
        'statut' => 'accepted',
        'action' => 'accepted',
    ]);

    PlanningHistorique::create([
        'planning_id' => $planning->id,
        'action' => 'accepted',
        'comment' => null,
    ]);

    return response()->json([
        'message' => 'Planning accepté',
        'planning' => $planning]);
}

public function refuse(Request $request, $id)
{
   
    if (!auth()->user()->is_admin) {
        return response()->json(['message' => 'Forbidden'], 403);
   
    }

    $request->validate([
        'comment' => 'required|string'
    ]);

    $planning = Planning::findOrFail($id);

    $planning->update([
        'statut' => 'refused',
        'action' => 'refused',
    ]);

    PlanningHistorique::create([
        'planning_id' => $planning->id,
        'action' => 'refused',
        'comment' => $request->comment,
    ]);

   return response()->json([
        'message' => 'Planning refusé',
        'planning' => $planning
    ]);
}

}
