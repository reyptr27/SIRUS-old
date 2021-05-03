<?php

namespace App\Models\FormulirHRD;

use Illuminate\Database\Eloquent\Model;

class Form_Cuti extends Model
{
    protected $table = 'hrd_cuti_header';
    protected $guarded = [];

    public function karyawan(){
        return $this->belongsTo(User::class);
    }
}
