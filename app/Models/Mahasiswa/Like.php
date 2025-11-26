<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $primaryKey = 'like_id';
    
    protected $fillable = [
        'post_id',
        'user_id',
    ];
    
    public function user()
    { 
        // Menggunakan 'id' sebagai foreign key di tabel users (standar Laravel)
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id'); 
    }
    
    public function post()
    { 
        // Merujuk ke model Post di namespace Mahasiswa
        return $this->belongsTo(Post::class, 'post_id', 'post_id'); 
    }
}