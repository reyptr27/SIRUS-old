<?php

namespace App\Models\CAPA;

use Illuminate\Database\Eloquent\Model;

class CAPA extends Model
{
    protected $table = 'capa';
    protected $guarded = [];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class);
    }

    public function dari(){
        return $this->belongsTo(User::class, 'dari_id');
    }

    public function kepada(){
        return $this->belongsTo(Departemen::class, 'kepada_id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
