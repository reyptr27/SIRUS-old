<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'news_kategori';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User','created_by');
    }
}
