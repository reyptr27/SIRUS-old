<?php

namespace App\Models\Monitoring_Mesin;

use Illuminate\Database\Eloquent\Model;

class Penerimaan_Detail extends Model
{
    Protected $table = 'hd_penerimaan_detail';
    protected $guarded = [];

    public function header(){
        return $this->belongsTo(Penerimaan_Header::class); 
    }
}
