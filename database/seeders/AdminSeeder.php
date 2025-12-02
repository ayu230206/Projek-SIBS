<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'nama_lengkap' => 'Administrator Utama',
            'email' => 'admin@sawit.com',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang kuat
            'role' => 'admin', // <-- ROLE ADMIN
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
// JANGAN LUPA Panggil AdminSeeder di DatabaseSeeder.php