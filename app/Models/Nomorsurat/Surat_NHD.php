<?php

namespace App\Models\Nomorsurat;

use Illuminate\Database\Eloquent\Model;

class Surat_NHD extends Model
{
    protected $table = 'surat_nhd';
    protected $guarded = [];

    public function tujuan(){
        return $this->belongsTo(Tujuan_NHD::class);
    }

    public function kategori(){
        return $this->belongsTo(Kategori_NHD::class);
    }
}
