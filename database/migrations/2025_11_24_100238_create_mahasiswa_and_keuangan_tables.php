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
        // Tabel Mahasiswa Detail
        Schema::create('mahasiswa_detail', function (Blueprint $table) {
            // Foreign Key (FK) sekaligus Primary Key (PK)
            $table->foreignId('user_id')->primary()->constrained('users')->onDelete('cascade');
            
            $table->string('nim', 50)->unique();
            // Foreign Key ke tabel kampus
            $table->foreignId('kampus_id')->constrained('kampus')->onDelete('restrict');
            
            $table->string('program_studi');
            $table->unsignedSmallInteger('lama_studi')->nullable(); // Dalam semester
            $table->string('telepon', 20)->nullable();
            $table->text('alamat_domisili')->nullable();

            // Kolom untuk file/gambar dokumen Mahasiswa
            $table->string('path_ktp')->nullable();
            $table->string('path_kartu_mhs')->nullable();
            $table->string('path_transkrip_nilai')->nullable();
            $table->string('path_foto_formal')->nullable();

            // Data Akademik (di-input Admin)
            $table->decimal('ipk', 3, 2)->default(0.00);
            $table->decimal('ips_terakhir', 3, 2)->default(0.00);
            
            $table->softDeletes(); // Untuk menandakan status beasiswa berakhir (opsional)
            $table->timestamps();
        });

        // Tabel Keuangan (Pencairan Dana Beasiswa)
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel users (mahasiswa)
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('restrict');
            
            $table->string('semester', 50);
            $table->date('tanggal_transfer')->nullable();
            $table->decimal('jumlah_bulanan', 15, 2)->default(0.00);
            $table->decimal('jumlah_buku', 15, 2)->default(0.00);
            // Kolom total_transfer bisa dihitung di Model/Aplikasi, atau sebagai generated column
            $table->enum('status_pencairan', ['proses', 'ditransfer', 'diterima', 'ditangguhkan'])->default('proses');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_detail');
        Schema::dropIfExists('keuangan');
    }
};