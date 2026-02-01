<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $fillable = [
        'niveau', 'groupe', 'enseignant', 'module', 
        'jour', 'heure', 'salle', 'statut'
    ];
    public function historiques(){
        return $this->hasMany(HistoriqueM::class,'planning_id');
    }
}
