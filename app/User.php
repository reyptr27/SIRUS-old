<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Cabang;
use App\Models\Departemen;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'nik', 'jabatan', 
        'no_telp', 'jabatan', 'dept_id', 'atasan_id', 'cabang_id', 'image', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }
    public function dept(){
        return $this->belongsTo(Departemen::class);
    }

    public function atasan(){
        return $this->belongsTo(User::class); 

    }
}
