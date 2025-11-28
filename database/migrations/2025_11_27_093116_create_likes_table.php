<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id('like_id'); // primary key
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('tanggal_like')->useCurrent(); // otomatis isi
            $table->timestamps(); // penting agar relasi Laravel berjalan

            // Foreign Key
            $table->foreign('post_id')
                  ->references('post_id')
                  ->on('posts')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
