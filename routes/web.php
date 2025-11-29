<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// Mahasiswa Controllers
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\PostController;
use App\Http\Controllers\Mahasiswa\CommentController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
use App\Http\Controllers\Mahasiswa\ProyekAkhirController;
use App\Http\Controllers\Mahasiswa\MagangController;
use App\Http\Controllers\Mahasiswa\LikeController;
use App\Http\Controllers\Mahasiswa\LowonganKerjaController;
use App\Http\Controllers\Mahasiswa\LowonganMagangController;


//bpdpks

use App\Http\Controllers\Bpdpks\InfoKeuanganController;

// BPDPKS Controllers (Pastikan Path Controller Anda benar)
// Catatan: Anda HARUS mengimpor Controller BPDPKS di sini
// Contoh asumsi nama dan path Controller:
use App\Http\Controllers\Bpdpks\LowonganKerjaController as BpdpksLowonganKerjaController;
use App\Http\Controllers\Bpdpks\AdminNoteController;
use App\Http\Controllers\Bpdpks\FeedbackController;
// BPDPKS Middleware
use App\Http\Middleware\IsBpdpks; // <-- Pastikan ini sudah Anda buat!

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        // Logika redirect berdasarkan role
        $role = Auth::user()->role;
        if ($role == 'mahasiswa') {
            return redirect()->route('dashboard'); // Default ke dashboard Mahasiswa
        } elseif ($role == 'bpdpks') {
            return redirect()->route('bpdpks.dashboard');
        }
    }
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// START: Grup Middleware AUTH
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Default Dashboard (Akan diakses oleh Mahasiswa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================
    // ROUTES MAHASISWA (Pilihan: Tambahkan middleware IsMahasiswa::class di sini)
    // ============================================
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

        // FIX: route hapus yg sebelumnya salah
        Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        // ============================
        // PROYEK AKHIR (FINAL FIXED)
        // ============================
        Route::prefix('proyek')->name('proyek.')->group(function () {

            Route::get('/dashboard', [ProyekAkhirController::class, 'menu'])->name('dashboard');
            Route::get('/', [ProyekAkhirController::class, 'index'])->name('index');
            Route::post('/', [ProyekAkhirController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProyekAkhirController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProyekAkhirController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProyekAkhirController::class, 'destroy'])->name('destroy');
        });

        // ========================
        // MAGANG
        // ========================
        Route::prefix('magang')->name('magang.')->group(function () {
            Route::get('/dashboard', function () {
                return view('mahasiswa.magang.dashboard');
            })->name('dashboard');

            Route::get('/riwayat', [MagangController::class, 'index'])->name('riwayat');
            Route::get('/', [MagangController::class, 'index'])->name('index');

            Route::get('/ajukan', function () {
                return view('mahasiswa.magang.ajukan');
            })->name('ajukan');

            Route::post('/store', [MagangController::class, 'store'])->name('store');

            // Lowongan Magang
            Route::get('/lowongan', [LowonganMagangController::class, 'index'])->name('lowongan');
            Route::get('/lowongan/{id}', [LowonganMagangController::class, 'show'])->name('lowongan.show');
        });

        // ========================
        // LOWONGAN KERJA
        // ========================
        Route::prefix('lowongankerja')->name('lowongankerja.')->group(function () {
            Route::get('/', [LowonganKerjaController::class, 'index'])->name('index');
            Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show');
            Route::post('/{id}/lamar', [LowonganKerjaController::class, 'lamar'])->name('lamaran.store');
        });

    }); // END: Grup Prefix Mahasiswa

    // ============================================
    // ROUTES BPDPKS (Menggunakan nama class middleware secara langsung)
    // ============================================
    // Menggunakan IsBpdpks::class untuk membatasi akses ke role 'bpdpks'
    Route::middleware([IsBpdpks::class])->prefix('bpdpks')->name('bpdpks.')->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('bpdpks.dashboard');
        })->name('dashboard');


   
        Route::resource('keuangan', InfoKeuanganController::class)->except(['show']);

        // Tambahkan Route Approval Magang/Kampus di sini jika ada
        // Route::get('/internship-approval', [InternshipApprovalController::class, 'index'])->name('internship.approval');
    }); // END: Grup Prefix BPDPKS

}); // END: Grup Middleware AUTH
