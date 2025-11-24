<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Data Kampus harus dibuat DULUAN sebelum Mahasiswa menggunakannya
        $this->call([
            DataKampusSeeder::class, // <-- Pindahkan ke ATAS
            UserRoleSeeder::class,   // <-- Panggil setelah data kampus ada
        ]);
    }
}
