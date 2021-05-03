<?php

namespace App\Models\Nomorsurat;

use Illuminate\Database\Eloquent\Model;

class No_eksternal extends Model
{
    protected $table = 'no_eksternal';
    protected $guarded = [];

    public function surat_eksternal(){
        return $this->belongsTo(Surat_eksternal::class);
    }
}
