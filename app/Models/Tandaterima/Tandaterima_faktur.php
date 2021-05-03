<?php

namespace App\Models\Tandaterima;

use Illuminate\Database\Eloquent\Model;

class Tandaterima_faktur extends Model
{
    protected $table = 'tanda_terima_faktur';
    protected $guarded = [];

    public function tandaterima(){
        return $this->belongsTo(Tandaterima::class);
    }
}
