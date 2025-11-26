<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\PostController;
use App\Http\Controllers\Mahasiswa\CommentController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController; // Tambahkan import ini
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        
        // Postingan Forum
        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
        Route::post('posts/{post}/share', [PostController::class, 'share'])->name('posts.share');
        // Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
        // Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        // PROFIL MAHASISWA
        Route::get('profil', [MahasiswaProfileController::class, 'index'])->name('profil.index');
        Route::get('profil/edit', [MahasiswaProfileController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [MahasiswaProfileController::class, 'update'])->name('profil.update'); // Menggunakan PUT untuk update
        
        // Route Tambahan (Placeholder)
        Route::get('akademik', function () { /* Placeholder Akademik */ })->name('akademik.index');
        Route::get('magang', function () { /* Placeholder Magang */ })->name('magang.index');
        Route::get('proyek-akhir', function () { /* Placeholder Proyek Akhir */ })->name('proyek-akhir.index');
    });
});