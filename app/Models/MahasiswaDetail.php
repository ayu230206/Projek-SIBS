<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaDetail extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_detail';

    // Kolom fillable sesuai dengan migrasi mahasiswa_detail Anda
    protected $fillable = [
        'user_id', 'nim', 'kampus_id', 'program_studi', 'lama_studi', 
        'telepon', 'alamat_domisili', 'path_ktp', 'path_kartu_mhs', 
        'path_transkrip_nilai', 'path_foto_formal', 'ipk', 'ips_terakhir'
    ];
    
    // Relasi ke User (1:1)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke Kampus (N:1)
    public function kampus()
    {
        // Foreign key di tabel ini adalah 'kampus_id'
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }
}