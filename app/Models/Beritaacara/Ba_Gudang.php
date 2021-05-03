<?php

namespace App\Models\Beritaacara;

use Illuminate\Database\Eloquent\Model;

class Ba_Gudang extends Model
{
    protected $table = 'ba_gudang';
    protected $guarded = [];

    public function ba_gudang_barangs(){
        return $this->hasMany(Ba_Gudang_Barang::class);    
    }
}
