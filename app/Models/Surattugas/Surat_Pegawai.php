<?php

namespace App\Models\Surattugas;

use Illuminate\Database\Eloquent\Model;

class Surat_Pegawai extends Model
{
    protected $table = 'surat_tugas_pegawai';
    protected $guarded = [];

    public function surat(){
        return $this->belongTo(Surat_Tugas::class);
    }

    public function pegawai(){
        return $this->belongTo(User::class);
    }
}
