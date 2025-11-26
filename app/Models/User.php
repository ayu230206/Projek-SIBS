<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kampus; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';        
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'asal_kampus',
        'angkatan',
        'bio',
        'foto_profile',
        'status_aktif'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = true; 

    // Relasi ke Kampus (Sudah diperbaiki menggunakan 'id')
    public function kampus(){
        return $this->belongsTo(Kampus::class, 'asal_kampus', 'id');
    }
}