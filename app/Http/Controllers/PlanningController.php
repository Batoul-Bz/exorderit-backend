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
    $planning = Planning::create([
    'niveau' => '1ère',
    'groupe' => 'A',
    'enseignant' => 'Mme. Sara',
    'module' => 'Math',
    'jour' => 'Lundi',
    'heure' => '08:00',
    'salle' => '101',
    'statut' => 'draft',
    'action' => 'Voir les documents',
    'visible_to' => ['admin']
]);
    return response()->json($planning, 201);
    }
}
