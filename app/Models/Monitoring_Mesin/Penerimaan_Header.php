<?php

namespace App\Models\Monitoring_Mesin;

use Illuminate\Database\Eloquent\Model;

class Penerimaan_Header extends Model
{
    Protected $table = 'hd_penerimaan_header';
    protected $guarded = [];

    public function details(){
        return $this->hasMany(Penerimaan_Detail::class);
    }
}
