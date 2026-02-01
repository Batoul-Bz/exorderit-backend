<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueM extends Model
{
    protected $table='planning_historique';
    
    protected $fillable = [
        'planning_id', 'admin_id', 'action','comment'];

    public function planning(){
        return $this->belongsTo(Planning::class,'planning_id');
    }
}
