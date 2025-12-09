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
       Schema::table('magang_lowongan', function (Blueprint $table) {
        // Menambah kolom file_path yang boleh kosong
        $table->string('file_path')->nullable()->after('deadline');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang_lowongan', function (Blueprint $table) {
        $table->dropColumn('file_path');
    });
    }
};
