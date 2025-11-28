<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Bpdpks\KeuanganSeeder;
 // Import KeuanganSeeder Anda dari namespace Bpdpks
use App\Models\User; // Digunakan untuk membuat user BPDPKS admin
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the application's database.
     */
    public function run(): void
    {
        // Panggil seeder Awal yang Anda butuhkan (DataKampusSeeder dan UserRoleSeeder)
        $this->call([
            DataKampusSeeder::class, // Asumsi ini mengisi data awal statis kampus
            UserRoleSeeder::class,   // Asumsi ini mengisi role user
        ]);
        
        // Panggil seeder Data Fiktif dengan urutan yang logis:
        $this->call([
            // 1. KampusSeeder harus dipanggil (mengisi data Kampus fiktif)
            KampusSeeder::class,
            
            // 2. MahasiswaSeeder (membuat user 'mahasiswa' dan detailnya)
            MahasiswaSeeder::class,
            
            // 3. KeuanganSeeder (mengisi data keuangan mahasiswa yang baru dibuat)
            
        ]);
        
        // Tambahkan user Admin/BPDPKS utama untuk login
        User::create([
            'nama_lengkap' => 'BPDPKS User',
            'email' => 'bpdpks@admin.com',
            'password' => Hash::make('password'), // password: password
            'role' => 'bpdpks',
            'status_aktif' => true,
        ]);
        
        $this->command->info('Database berhasil di-seed dengan data lengkap.');
    }
}