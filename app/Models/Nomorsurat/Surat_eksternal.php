<?php

namespace App\Models\Nomorsurat;

use Illuminate\Database\Eloquent\Model;

class Surat_eksternal extends Model
{
    protected $table = 'surat_eksternal';
    protected $guarded = [];

    public function tujuan(){
        return $this->belongsTo(Tujuan_eksternal::class);
    }

    public function nomor(){
        return $this->hasOne(No_eksternal::class);
    }
}
