<?php

namespace App\Models\Nomorsurat;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Departemen;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
    protected $guarded = [];

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function up(){
        return $this->belongsTo(User::class, 'up_id', 'id');
    }

    public function departemen(){
        return $this->belongsTo(Departemen::class, 'dept_id', 'id');
    }
}
