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
use App\Http\Controllers\Mahasiswa\MahasiswaAkademikController;
use App\Http\Controllers\Mahasiswa\NotifikasiController;
use App\Http\Controllers\Mahasiswa\BankJudulProyekController;


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
use App\Http\Controllers\Bpdpks\DataMahasiswaController;
use App\Http\Controllers\Bpdpks\KampusKerjasamaController;
use App\Http\Controllers\Bpdpks\LowonganController; // <-- TAMBAHKAN INI


// --- Imports Controller Admin (BARU) ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; 
use App\Http\Controllers\Admin\KampusController as AdminKampusController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Admin\BeasiswaController as AdminBeasiswaController;
use App\Http\Controllers\Admin\MagangLowonganController as AdminMagangLowonganController;
use App\Http\Controllers\Admin\PenelitianLombaController as AdminPenelitianLombaController;
use App\Http\Controllers\Admin\KeuanganController as AdminKeuanganController;
use App\Http\Controllers\Admin\RegisUlangController as AdminRegisUlangController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'mahasiswa') {
            return redirect()->route('dashboard'); 
        } elseif ($role == 'bpdpks') {
            return redirect()->route('bpdpks.dashboard');
        } elseif ($role == 'admin') {
            // FIX: Redirect ke dashboard Admin
            return redirect()->route('admin.dashboard'); 
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
            Route::get('/bank-judul-proyek-akhir', [BankJudulProyekController::class, 'index'])
                ->name('bankjudul');
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
            Route::get('/riwayat', [LowonganKerjaController::class, 'riwayat'])->name('riwayat');
            Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show');
            Route::post('/{id}/lamar', [LowonganKerjaController::class, 'lamar'])->name('lamaran.store');
        });

        // AKADEMIK MAHASISWA
        Route::prefix('akademik')->name('akademik.')->group(function () {

            // Dashboard Akademik Mahasiswa
            Route::get('/dashboard', [MahasiswaAkademikController::class, 'dashboard'])
                ->name('dashboard');

            // Halaman Upload Dokumen
            Route::get('/upload', [MahasiswaAkademikController::class, 'uploadPage'])
                ->name('upload.page');

            // Proses Upload Dokumen
            Route::post('/upload', [MahasiswaAkademikController::class, 'uploadDokumen'])
                ->name('upload');

            // Hapus Dokumen Mahasiswa
            Route::delete('/dokumen/{dokumen}', [MahasiswaAkademikController::class, 'destroyDokumen'])
                ->name('dokumen.destroy');
        });
        //notifikasi 
        Route::get('notifikasi', [NotifikasiController::class, 'index'])
            ->name('notifikasi');
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
        Route::resource('kerjasama', KampusKerjasamaController::class)->except(['show']); // <-- TAMBAHKAN INI


        Route::resource('lowongan', LowonganController::class);

        // Rute Monitoring Aplikasi
        Route::get('lowongan/{lowongan}/aplikasi', [LowonganController::class, 'monitoringAplikasi'])->name('lowongan.monitoring');
        Route::post('lowongan/aplikasi/{aplikasidata}/proses', [LowonganController::class, 'prosesAplikasi'])->name('lowongan.proses_aplikasi');
        Route::resource('datamahasiswa', DataMahasiswaController::class)->only(['index', 'show']);
        // ...

        // Tambahkan Route Approval Magang/Kampus di sini jika ada
        // Route::get('/internship-approval', [InternshipApprovalController::class, 'index'])->name('internship.approval');
    }); // END: Grup Prefix BPDPKS

}); // END: Grup Middleware AUTH

    // ============================================
    // ROUTES KHUSUS ADMIN (FULL CONTROL)
    // ============================================
    Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
        
        // 1. Dashboard Admin
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 2. Manajemen Kampus (Admin memverifikasi dokumen MoU)
        Route::resource('kampus', AdminKampusController::class);
        
        // 3. Manajemen Mahasiswa & Akademik
        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            // Daftar Mahasiswa (CRUD data diri dasar)
            Route::resource('/', AdminMahasiswaController::class)->except(['show']); 
            
            // Data Akademik / Nilai (Mass Upload & OLAP Report) 
            Route::get('nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');
            Route::post('nilai/upload', [AdminNilaiController::class, 'massUpload'])->name('nilai.mass_upload'); 
            Route::get('nilai/report', [AdminNilaiController::class, 'reportOlap'])->name('nilai.olap'); 
        });

        // 4. Manajemen Program Beasiswa & Pengumuman
        Route::resource('beasiswa', AdminBeasiswaController::class); 
        
        // 5. Manajemen Lowongan Magang/Kerja & Penelitian/Lomba
        Route::resource('lowongan', AdminMagangLowonganController::class); 
        Route::resource('penelitian-lomba', AdminPenelitianLombaController::class); 

        // 6. Manajemen Registrasi Ulang & Feedback (Sistem Hard Gate) [Image of User Registration Flowchart with Approval Step]
        Route::prefix('regis-ulang')->name('regis-ulang.')->group(function () {
            // Review dan Approval Registrasi Ulang
            Route::get('/', [AdminRegisUlangController::class, 'index'])->name('index');
            Route::post('{regis_ulang_id}/approve', [AdminRegisUlangController::class, 'approve'])->name('approve');
            Route::post('{regis_ulang_id}/reject', [AdminRegisUlangController::class, 'reject'])->name('reject');
            
            // Melihat semua feedback (Kritik dan Saran)
            Route::get('feedback', [AdminFeedbackController::class, 'index'])->name('feedback');
        });

        // 7. Keuangan (Akses Penuh/Audit untuk Admin)
        Route::resource('keuangan', AdminKeuanganController::class)->except(['create']); 
        Route::post('keuangan/{id}/transfer', [AdminKeuanganController::class, 'markAsTransferred'])->name('keuangan.transfer'); 
    });
    // END: Grup Prefix Admin
