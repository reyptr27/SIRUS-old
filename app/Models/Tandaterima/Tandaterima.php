<?php

namespace App\Models\Tandaterima;

use Illuminate\Database\Eloquent\Model;

class Tandaterima extends Model
{
    protected $table = 'tanda_terima';
    protected $guarded = [];

    public function tandaterimafaktur(){
        return $this->hasMany(Tandaterima_faktur::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
