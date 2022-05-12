<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;
use App\Models\Arsip\Jenis_arsip;

class Arsip extends Model
{
    protected $table = 'arsip';
    protected $guarded = [];

    public function jenis(){
        return $this->belongsTo(Jenis_arsip::class, 'jenis_id', 'id');
    }
}
