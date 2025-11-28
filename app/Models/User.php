<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kampus; 
// Import model-model baru
use App\Models\Bpdpks\Keuangan; // Keuangan berada di namespace Bpdpks
use App\Models\MahasiswaDetail; 

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

    // --- RELASI BARU DITAMBAHKAN DI SINI ---
    
    /**
     * Relasi ke data Keuangan (1-to-many).
     * Foreign Key: mahasiswa_id di tabel 'keuangan'
     */
    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'mahasiswa_id', 'id');
    }

    /**
     * Relasi ke Detail Mahasiswa (1-to-1).
     * Foreign Key: user_id di tabel 'mahasiswa_detail'
     */
    public function detail()
    {
        return $this->hasOne(MahasiswaDetail::class, 'user_id', 'id');
    }

    // Relasi ke Kampus (Sudah ada)
    public function kampus(){
        return $this->belongsTo(Kampus::class, 'asal_kampus', 'id');
    }
}