<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'kampus';

    // Menentukan custom primary key (jika tidak menggunakan 'id')
    protected $primaryKey = 'kampus_id';

    // Mematikan timestamps (created_at & updated_at) jika tabel tidak memilikinya
    public $timestamps = false;

    protected $fillable = [
        'nama_kampus',
        'alamat',
        'kontak_person',
        'status_kerjasama',
        'path_mou_dokumen',
    ];
}