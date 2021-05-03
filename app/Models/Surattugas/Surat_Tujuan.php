<?php

namespace App\Models\Surattugas;

use Illuminate\Database\Eloquent\Model;

class Surat_Tujuan extends Model
{
    protected $table = 'surat_tugas_tujuan';
    protected $guarded = [];

    public function surat(){
        return $this->belongTo(Surat_Tugas::class);
    }

    public function tujuan(){
        return $this->belongTo(Tujuan_St::class);
    }
}
