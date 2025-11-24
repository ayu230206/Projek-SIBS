<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kampus')->insert([
            [
                'nama_kampus' => 'Institut Teknologi Sawit Indonesia (ITSI)',
                'alamat' => 'Medan, Sumatera Utara',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kampus' => 'Politeknik Kelapa Sawit Citra Widya Edukasi (CWE)',
                'alamat' => 'Bekasi, Jawa Barat',
                'status_kerjasama' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}