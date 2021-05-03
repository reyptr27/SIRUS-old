<?php

namespace App\Models\Monitoring_Mesin;

use Illuminate\Database\Eloquent\Model;

class Tipe_Mesin extends Model
{
    Protected $table = 'hd_tipe_mesin';
    protected $guarded = [];

    public function jenis(){
        return $this->belongsTo(Jenis_Mesin::class); 
    }
}
