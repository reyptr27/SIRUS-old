<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Maintenance_cctv extends Model
{
    Protected $table = 'maintenance_cctv';
    protected $guarded = [];


    public function atasan(){
        return $this->belongsTo(User::class); 

    }

    
}
