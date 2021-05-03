<?php

namespace App\Models\TAM\BA;

use Illuminate\Database\Eloquent\Model;

class RS extends Model
{
    protected $table = 'tam_ba_rs';
    protected $fillable = ['nama_rs','status','cabang_id'];
}
