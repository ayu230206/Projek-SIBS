<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\PostController;
use App\Http\Controllers\Mahasiswa\CommentController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
use App\Http\Controllers\Mahasiswa\ProyekAkhirController;
use App\Http\Controllers\Mahasiswa\MagangController;
use App\Http\Controllers\Mahasiswa\LikeController;
use App\Http\Controllers\Mahasiswa\LowonganKerjaController;
use App\Http\Controllers\Mahasiswa\LowonganMagangController;
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

        // POSTS
        Route::resource('posts', PostController::class);

        // LIKE & UNLIKE
        Route::post('posts/{post_id}/like', [LikeController::class, 'store'])->name('posts.like');
        Route::delete('posts/{post_id}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

        // KOMENTAR
        Route::post('posts/{post_id}/comment', [CommentController::class, 'store'])->name('posts.comment.store');
        Route::delete('posts/comment/{comment_id}', [CommentController::class, 'destroy'])->name('posts.comment.destroy');

        // SHARE
        Route::post('posts/{post}/share', [PostController::class, 'share'])->name('posts.share');

        // PROFILE
        Route::get('profil', [MahasiswaProfileController::class, 'index'])->name('profil.index');
        Route::get('profil/edit', [MahasiswaProfileController::class, 'edit'])->name('profil.edit');
        Route::put('profil', [MahasiswaProfileController::class, 'update'])->name('profil.update');
        Route::delete('/mahasiswa/posts/{post}', [PostController::class, 'destroy'])->name('mahasiswa.posts.destroy');

        // PROYEK AKHIR
        Route::prefix('proyek')->name('proyek.')->group(function () {
            Route::get('/dashboard', [ProyekAkhirController::class, 'menu'])->name('dashboard');
            Route::get('/', [ProyekAkhirController::class, 'index'])->name('index');
            Route::post('/store', [ProyekAkhirController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProyekAkhirController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProyekAkhirController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProyekAkhirController::class, 'destroy'])->name('destroy');
        });

        // MAGANG
        Route::prefix('magang')->name('magang.')->group(function () {
            Route::get('/dashboard', function () {
                return view('admin.mahasiswa.magang.dashboard');
            })->name('dashboard');
            Route::get('/riwayat', [MagangController::class, 'index'])->name('riwayat');
            Route::get('/', [MagangController::class, 'index'])->name('index');
            Route::get('/ajukan', function () {
                return view('admin.mahasiswa.magang.ajukan');
            })->name('ajukan');
            Route::post('/store', [MagangController::class, 'store'])->name('store');

            // Lowongan Magang
            Route::get('/lowongan', [LowonganMagangController::class, 'index'])->name('lowongan');
            Route::get('/lowongan/{id}', [LowonganMagangController::class, 'show'])->name('lowongan.show');
        });

        // LOWONGAN KERJA
        Route::prefix('lowongankerja')->name('lowongankerja.')->group(function () {
            Route::get('/', [LowonganKerjaController::class, 'index'])->name('index'); // daftar lowongan
            Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show'); // detail lowongan

            // Lamaran kerja
            Route::post('/{id}/lamar', [LowonganKerjaController::class, 'lamar'])->name('lamaran.store');
        });

    });
});
