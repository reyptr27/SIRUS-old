<?php

namespace App\Models\Monitoring_Mesin;

use Illuminate\Database\Eloquent\Model;

class Pengiriman_Header extends Model
{
    Protected $table = 'hd_pengiriman_header';
    protected $guarded = [];

    public function detail(){
        return $this->hasMany(Pengiriman_Detail::class); 
    }
}
