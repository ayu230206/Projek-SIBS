<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kampus; // Pastikan model ini ada

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin (Role: admin)
        User::create([
            'name' => 'Super Admin Beasiswa',
            'email' => 'admin@bpdpks.id',
            'password' => Hash::make('password'), // Gunakan password yang kuat di production
            'role' => 'admin',
        ]);

        // 2. Akun BPDPKS (Role: bpdpks)
        User::create([
            'name' => 'Naldi BPDPKS',
            'email' => 'naldi@bpdpks.id',
            'password' => Hash::make('password'),
            'role' => 'bpdpks',
        ]);

        // 3. Akun Mahasiswa Contoh (Role: mahasiswa)
        $mahasiswaUser = User::create([
            'name' => 'Fulan Mahasiswa',
            'email' => 'mahasiswa@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        
        // Asumsi data Kampus ID 1 sudah ada dari DataKampusSeeder
        $kampusId = Kampus::first()->id ?? 1;

        // Tambahkan Detail Mahasiswa
        DB::table('mahasiswa_detail')->insert([
            'user_id' => $mahasiswaUser->id,
            'nim' => '20230001',
            'kampus_id' => $kampusId,
            'program_studi' => 'Teknologi Hasil Perkebunan',
            'lama_studi' => 3, // Semester 3
            'telepon' => '081234567890',
            'alamat_domisili' => 'Jl. Kebun Sawit No. 10',
            'ipk' => 3.75,
            'ips_terakhir' => 3.80,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}