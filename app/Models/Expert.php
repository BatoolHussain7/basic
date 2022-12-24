<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(user::class);
    }

    public function consultations()
    {
       return $this->belongsToMany(Consultation::class,'consul_experts','expert_id','consultation_id');
    }

    public function favoriteusers()
    {
       return $this->belongsToMany(user::class,'favorites');
    }
}
