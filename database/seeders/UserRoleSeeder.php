<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kampus;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'nama_lengkap' => 'Super Admin Beasiswa',
            'email' => 'admin@bpdpks.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        // 2. Akun BPDPKS
        User::create([
            'nama_lengkap' => 'Naldi BPDPKS',
            'email' => 'naldi@bpdpks.id',
            'password' => Hash::make('password'),
            'role' => 'bpdpks',
            'status_aktif' => true,
        ]);

        // 3. Akun Mahasiswa
        $mahasiswa = User::create([
            'nama_lengkap' => 'Fulan Mahasiswa',
            'email' => 'mahasiswa@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'asal_kampus' => Kampus::first()->id ?? null,
            'angkatan' => '2023',
            'bio' => null,
            'foto_profile' => null,
            'status_aktif' => true,
        ]);

        // Jika kamu punya tabel mahasiswa_detail — pastikan migrasinya ada!
        DB::table('mahasiswa_detail')->insert([
            'user_id' => $mahasiswa->id,
            'nim' => '20230001',
            'kampus_id' => Kampus::first()->id ?? null,
            'program_studi' => 'Teknologi Hasil Perkebunan',
            'lama_studi' => 3,
            'telepon' => '081234567890',
            'alamat_domisili' => 'Jl. Kebun Sawit No. 10',
            'ipk' => 3.75,
            'ips_terakhir' => 3.80,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
