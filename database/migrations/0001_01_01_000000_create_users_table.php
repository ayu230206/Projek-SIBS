<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Users (Login & Peran)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'bpdpks', 'mahasiswa']);
            $table->timestamps();
        });

        // Tabel Kampus
        Schema::create('kampus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampus')->unique();
            $table->text('alamat')->nullable();
            $table->string('kontak_person')->nullable();
            $table->enum('status_kerjasama', ['aktif', 'pending', 'ditolak'])->default('pending');
            // Kolom dokumen kerjasama
            $table->string('path_mou_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('kampus');
    }
};