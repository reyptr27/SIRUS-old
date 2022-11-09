<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Model;
use App\Models\Departemen;
use App\Models\Audit\AuditLokasi;

class AuditEmail extends Model
{
    protected $table = 'audit_email';
    protected $guarded = [];

    public function lokasi(){
        return $this->belongsTo(AuditLokasi::class);
    }
   
    public function dept(){
        return $this->belongsTo(Departemen::class, 'dept_id');
    }
}
