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
    try{$planning = Planning::findOrFail($id);
    $existingRoles = json_decode($planning->visible_to, true) ?? []; // تحويل JSON إلى array

    $newRoles = $request->input('roles'); 

    $planning->visible_to = array_unique(array_merge($planning->visible_to ?? [], $newRoles));

    $planning->statut = 'published';
    $planning->save();

    return response()->json([
        'message' => 'Planning published successfully',
        'planning' => $planning
    ]);}catch(\Throwable $e) {
        return response()->json([
            'message' => 'Server error',
            'error' => $e->getMessage()
        ], 500);
    }
    
}

}
