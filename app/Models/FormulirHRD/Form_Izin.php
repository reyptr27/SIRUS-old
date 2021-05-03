<?php

namespace App\Models\FormulirHRD;

use Illuminate\Database\Eloquent\Model;

class Form_Izin extends Model
{
    protected $table = 'hrd_izin';
    protected $guarded = [];

    public function karyawan(){
        return $this->belongsTo(User::class);
    }
}
