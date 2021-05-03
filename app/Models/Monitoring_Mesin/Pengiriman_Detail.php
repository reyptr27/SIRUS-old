<?php

namespace App\Models\Monitoring_Mesin;

use Illuminate\Database\Eloquent\Model;

class Pengiriman_Detail extends Model
{
    Protected $table = 'hd_detail_kiriman';
    protected $guarded = [];

    public function header(){
        return $this->belongsTo(Pengiriman_Header::class); 
    }
}
