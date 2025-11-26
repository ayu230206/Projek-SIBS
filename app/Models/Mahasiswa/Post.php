<?php

namespace App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_id';
    
    protected $fillable = [
        'user_id',
        'isi',
        'gambar',
        'tanggal_post',
    ];

    protected $casts = [
        'tanggal_post' => 'datetime',
    ];

    public function user() 
    {
        // Mengasumsikan Model User menggunakan 'id' sebagai Primary Key standar Laravel
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    public function comments() 
    {
        // Relasi One-to-Many ke Comment
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }
    
    public function likes() 
    {
        // Relasi One-to-Many ke Like
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }
    
    public function shares() 
    {
        // Relasi One-to-Many ke Share
        return $this->hasMany(Share::class, 'post_id', 'post_id');
    }
}