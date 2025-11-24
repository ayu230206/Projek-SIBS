<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mendefinisikan nama tabel yang benar
    protected $table = 'kampus'; 

    protected $fillable = [
        'nama_kampus',
        'alamat',
        'kontak_person',
        'status_kerjasama',
        'path_mou_dokumen',
    ];
}