<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeasiswaProgram extends Model
{
    use HasFactory;
    
    protected $table = 'beasiswa_program';

    protected $fillable = [
        'judul', 
        'isi_informasi', 
        'tanggal_mulai', 
        'tanggal_berakhir',
        'path_banner_poster',
        'path_dokumen_panduan',
        'kontak_person_bpdpks',
        'created_by_user_id',
    ];

    // Relasi ke User (Admin/BPDPKS) yang membuat program (untuk log/akuntabilitas)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}