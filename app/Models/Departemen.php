<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Divisi;

class Departemen extends Model
{
    protected $table = 'm_departemen';
    protected $guarded = [];

    public function divisi(){
        return $this->belongsTo(Divisi::class);
    }
}
