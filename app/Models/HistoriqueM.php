<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueM extends Model
{
    protected $fillable = [
        'planning_id', 'admin_id', 'action','comment'    ];
    public function planning_historiques(){
        return $this->belongsTo(Planning::class);
    }
}
