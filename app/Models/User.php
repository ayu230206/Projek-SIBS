<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kampus;
use App\Models\Bpdpks\Keuangan;
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

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'mahasiswa_id', 'id');
    }

    public function detail()
    {
        return $this->hasOne(MahasiswaDetail::class, 'user_id', 'id');
    }

    public function kampus()
    {
        return $this->belongsTo(Kampus::class, 'asal_kampus', 'id');
    }


    public function detailMahasiswa()
{
    // Relasi one-to-one ke detail mahasiswa
    return $this->hasOne(MahasiswaDetail::class, 'user_id');
}
}