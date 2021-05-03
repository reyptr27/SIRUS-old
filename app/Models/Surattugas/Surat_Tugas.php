<?php

namespace App\Models\Surattugas;

use Illuminate\Database\Eloquent\Model;

class Surat_Tugas extends Model
{
    protected $table = 'surat_tugas';
    protected $guarded = [];

    public function pegawais(){
        return $this->hasMany(Surat_Pegawai::class);    
    }

    public function tujuans(){
        return $this->hasMany(Surat_Tujuan::class);
    }

    public function tanggals(){
        return $this->hasMany(Surat_Tugas_Tanggal::class);
    }
}
