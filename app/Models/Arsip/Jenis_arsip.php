<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Jenis_arsip extends Model
{
    protected $table = 'jenis_arsip';
    protected $guarded = [];

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
