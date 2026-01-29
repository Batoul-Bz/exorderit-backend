<?php

namespace App\Http\Controllers;
use App\Models\Planning;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    /*
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
*/
public function index(Request $request)
{
    //$user = $request->user();      
    //$role = $user->role;           

    //$plannings = Planning::whereJsonContains('visible_to', $role)->get();

    return response()->json(['plannings'=> Planning::all()]);
}

public function accept(Planning $planning)
{
    
    if (!auth()->user()->is_admin) {
       return response()->json(['message' => 'Forbidden']);
    
    }

    $planning->update([
        'statut' => 'accepted',
    ]);

    Historique::create([
        'planning_id' => $planning->id,
        'admin_id' => auth()->id(),
        'action' => 'accepted',
    ]);

    return redirect()->back()->with('success','Planning accepted successfuly');
}

public function refuse(Request $request, $id)
{
   
    if (!auth()->user()->is_admin) {
        return response()->json(['message' => 'Forbidden']);
   
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
