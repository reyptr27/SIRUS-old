<?php

namespace App\Models\Permintaan;


use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    protected $table = 'perbaikan';
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
