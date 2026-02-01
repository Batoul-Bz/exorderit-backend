<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileChefDController extends Controller
{
    public function index(){
        //$user = Auth::user();
        $user=auth()->user();

        if(!$user || !$user->is_admin){
            return response()->json(['message'=>'Unauthorized'],403);
        }

        return response()->json([
            'id'=>$user->id,
            
            'name'=>$user->name,
            'familyName'=>$user->familyName ?? null,
            'dateNaissance'=>$user->dateNaissance ?? null,
            'ville'=>$user->ville ?? null,
            'num'=>$user->num ?? null,

            'email'=>$user->email,
            'password'=>$user->password,
            'functionPoste'=>$user->functionPoste ?? null,
            'lieuTravail'=>$user->lieuTravail ?? null,
            

            'experience'=>$user->experience ?? null,
            'certificate'=>$user->certificate ?? null,
            
            'role'=>$user->role,
            'created-at'=>$user->created_at->toDateString(),
        ]);
    }
}
