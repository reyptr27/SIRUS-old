<?php

namespace App\Models\Permintaan;
use App\Models\Cabang;
use App\Models\Departemen;


use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $table = 'pengadaan';
    protected $guarded = [];

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }
    public function dept(){
        return $this->belongsTo(Departemen::class);
    }

    public function atasan(){
        return $this->belongsTo(User::class); 

    }

    public function jenispengajuan(){
        return $this->belongsTo(Jenis_Permintaan::class);
    }
}
