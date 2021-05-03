<?php

namespace App\Models\Permintaan;
use App\Models\Cabang;
use App\Models\Departemen;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
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

}
