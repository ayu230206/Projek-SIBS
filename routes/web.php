<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// ============================================
// MAHASISWA Controllers
// ============================================
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\PostController;
use App\Http\Controllers\Mahasiswa\CommentController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
use App\Http\Controllers\Mahasiswa\ProyekAkhirController;
use App\Http\Controllers\Mahasiswa\MagangController;
use App\Http\Controllers\Mahasiswa\LikeController;
use App\Http\Controllers\Mahasiswa\LowonganKerjaController;
use App\Http\Controllers\Mahasiswa\LowonganMagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaAkademikController;
use App\Http\Controllers\Mahasiswa\NotifikasiController;
use App\Http\Controllers\Mahasiswa\FeedbackController as MahasiswaFeedbackController;
use App\Http\Controllers\Mahasiswa\BankJudulProyekController;

// ============================================
// BPDPKS Controllers
// ============================================
use App\Http\Controllers\Bpdpks\InfoKeuanganController;
use App\Http\Controllers\Bpdpks\LowonganController;
use App\Http\Controllers\Bpdpks\DataMahasiswaController;
use App\Http\Controllers\Bpdpks\KampusKerjasamaController;
use App\Http\Middleware\IsBpdpks;
use App\Http\Controllers\Bpdpks\FeedbackController as BpdpksFeedbackController;

// ============================================
// 1. ROOT & AUTH ROUTES
// ============================================
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'mahasiswa') {
            return redirect()->route('dashboard');
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

// ============================================
// 2. GRUP MIDDLEWARE AUTH
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Default Dashboard Mahasiswa
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- ROUTES MAHASISWA ---
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

        // DELETE POST
        Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        // PROYEK AKHIR
        Route::prefix('proyek')->name('proyek.')->group(function () {
            Route::get('/dashboard', [ProyekAkhirController::class, 'menu'])->name('dashboard');
            Route::get('/', [ProyekAkhirController::class, 'index'])->name('index');
            Route::post('/', [ProyekAkhirController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProyekAkhirController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProyekAkhirController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProyekAkhirController::class, 'destroy'])->name('destroy');
            Route::get('/bankjudul', [BankJudulProyekController::class, 'index'])->name('bankjudul');
        });

        // MAGANG
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

            Route::get('/lowongan', [LowonganMagangController::class, 'index'])->name('lowongan');
            Route::get('/lowongan/{lowongan}', [LowonganMagangController::class, 'show'])->name('lowongan.show');
            Route::post('/lowongan/{lowongan}/apply', [LowonganMagangController::class, 'apply'])->name('lowongan.apply');
        });

        // LOWONGAN KERJA
        Route::prefix('lowongankerja')->name('lowongankerja.')->group(function () {
            Route::get('/', [LowonganKerjaController::class, 'index'])->name('index');
            Route::get('/riwayat', [LowonganKerjaController::class, 'riwayat'])->name('riwayat');
            Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show');
            Route::post('/{id}/lamar', [LowonganKerjaController::class, 'lamar'])->name('lamaran.store');
        });

        // AKADEMIK MAHASISWA
        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/dashboard', [MahasiswaAkademikController::class, 'dashboard'])->name('dashboard');
            Route::get('/upload', [MahasiswaAkademikController::class, 'uploadPage'])->name('upload.page');
            Route::post('/upload', [MahasiswaAkademikController::class, 'uploadDokumen'])->name('upload');
            Route::delete('/dokumen/{dokumen}', [MahasiswaAkademikController::class, 'destroyDokumen'])->name('dokumen.destroy');
        });

        // FEEDBACK MAHASISWA
        Route::prefix('feedback')->name('feedback.')->group(function () {
            Route::get('/', [MahasiswaFeedbackController::class, 'index'])->name('index');
            Route::post('/', [MahasiswaFeedbackController::class, 'store'])->name('store');
        });

        // NOTIFIKASI
        Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
        Route::delete('notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
        Route::delete('notifikasi', [NotifikasiController::class, 'destroyAll'])->name('notifikasi.destroyAll');
    });

    // --- ROUTES BPDPKS ---
    Route::middleware([IsBpdpks::class])->prefix('bpdpks')->name('bpdpks.')->group(function () {
        Route::get('/dashboard', [DataMahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/chart-data-api', [DataMahasiswaController::class, 'getChartDataApi'])->name('chartdata.api');

        Route::resource('keuangan', InfoKeuanganController::class)->except(['show']);
        Route::resource('kerjasama', KampusKerjasamaController::class)->except(['show']);
        Route::resource('lowongan', LowonganController::class);

        Route::get('lowongan/{lowongan}/aplikasi', [LowonganController::class, 'monitoringAplikasi'])->name('lowongan.monitoring');
        Route::post('lowongan/aplikasi/{aplikasidata}/proses', [LowonganController::class, 'prosesAplikasi'])->name('lowongan.proses_aplikasi');

        Route::resource('datamahasiswa', DataMahasiswaController::class)->only(['index', 'show']);
<<<<<<< HEAD
        Route::resource('feedback', BpdpksFeedbackController::class)->only(['index', 'show']);
    });
});
=======
    }); // END: Grup Prefix BPDPKS


}); 
>>>>>>> c898c16f41558f32b8b8e9199762511f8af006f7
