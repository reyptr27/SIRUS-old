<?php

namespace App\Models\Nomorsurat;

use Illuminate\Database\Eloquent\Model;

class Surat_HD extends Model
{
    protected $table = 'surat_hd';
    protected $guarded = [];

    public function tujuan(){
        return $this->belongsTo(Tujuan_HD::class);
    }

    public function kategori(){
        return $this->belongsTo(Kategori_HD::class);
    }
}
