<?php

namespace App\Models\FormulirHRD;

use Illuminate\Database\Eloquent\Model;

class Form_Unpaid extends Model
{
    protected $table = 'hrd_unpaid';
    protected $guarded = [];

    public function karyawan(){
        return $this->belongsTo(User::class);
    }
}
