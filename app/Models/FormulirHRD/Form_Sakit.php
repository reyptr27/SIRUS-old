<?php

namespace App\Models\FormulirHRD;

use Illuminate\Database\Eloquent\Model;

class Form_Sakit extends Model
{
    protected $table = 'hrd_sakit';
    protected $guarded = [];

    public function karyawan(){
        return $this->belongsTo(User::class);
    }
}
