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
use App\Http\Controllers\Mahasiswa\LowonganMagangController; // <-- CONTROLLER MAHASISWA
use App\Http\Controllers\Mahasiswa\MahasiswaAkademikController;
use App\Http\Controllers\Mahasiswa\NotifikasiController;


// ============================================
// BPDPKS Controllers
// ============================================
use App\Http\Controllers\Bpdpks\InfoKeuanganController;
use App\Http\Controllers\Bpdpks\LowonganController; // <-- CONTROLLER UTAMA LOWONGAN
use App\Http\Controllers\Bpdpks\DataMahasiswaController;
use App\Http\Controllers\Bpdpks\KampusKerjasamaController;
// BPDPKS Middleware
use App\Http\Middleware\IsBpdpks; // <-- Pastikan ini sudah Anda buat!

// ============================================
// admin Controllers
// ============================================
use App\Http\Controllers\Admin\AdminDashboardController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminKampusController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminMahasiswaController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminMahasiswaAkademikController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminMahasiswaDokumenController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminNilaiController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\DataBeasiswaController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminMagangLowonganController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\PenelitianLombaController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminRegisUlangController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminFeedbackController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminKeuanganController; // <-- DITAMBAHKAN
use App\Http\Controllers\Admin\AdminNotifikasiController; // <-- DITAMBAHKAN
use App\Http\Middleware\AdminMiddleware;



// ============================================
// 1. ROOT & AUTH ROUTES
// ============================================


Route::get('/', function () {
    if (Auth::check()) {
        // Logika redirect berdasarkan role
        $role = Auth::user()->role;
        if ($role == 'mahasiswa') {
            return redirect()->route('dashboard'); // Default ke dashboard Mahasiswa (URL: /dashboard)
        } elseif ($role == 'bpdpks') {
            return redirect()->route('bpdpks.dashboard'); // URL: /bpdpks/dashboard
        }
        elseif ($role == 'admin') {
            return redirect()->route('admin.dashboard'); // URL: /admin/dashboard (setelah perbaikan)
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

    // Default Dashboard (Akan diakses oleh Mahasiswa)
    // URL: /dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---
    // ROUTES MAHASISWA
    // ---
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
        });

        // ========================
        // 🚀 MAGANG (Perubahan Utama di Sini)
        // ========================
        Route::prefix('magang')->name('magang.')->group(function () {
            Route::get('/dashboard', function () {
                return view('mahasiswa.magang.dashboard');
            })->name('dashboard');

            // Rute Pengajuan Magang Mandiri
            Route::get('/riwayat', [MagangController::class, 'index'])->name('riwayat');
            Route::get('/', [MagangController::class, 'index'])->name('index'); // Portal Magang
            Route::get('/ajukan', function () {
                return view('mahasiswa.magang.ajukan');
            })->name('ajukan');
            Route::post('/store', [MagangController::class, 'store'])->name('store');

            // Lowongan Magang DARI BPDPKS
            Route::get('/lowongan', [LowonganMagangController::class, 'index'])->name('lowongan');
            Route::get('/lowongan/{lowongan}', [LowonganMagangController::class, 'show'])->name('lowongan.show');
            Route::post('/lowongan/{lowongan}/apply', [LowonganMagangController::class, 'apply'])->name('lowongan.apply'); // <-- RUTE BARU APPLY
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
        
        // Notifikasi
        Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');

    }); // END: Grup Prefix Mahasiswa

    // ---
    // ROUTES BPDPKS
    // ---
    // Menggunakan alias string jika sudah didaftarkan di bootstrap/app.php
    Route::middleware(['bpdpks'])->prefix('bpdpks')->name('bpdpks.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DataMahasiswaController::class, 'dashboard'])->name('dashboard'); 
        Route::get('/chart-data-api', [DataMahasiswaController::class, 'getChartDataApi'])->name('chartdata.api');

        // Manajemen Keuangan & Kerjasama
        Route::resource('keuangan', InfoKeuanganController::class)->except(['show']);
        Route::resource('kerjasama', KampusKerjasamaController::class)->except(['show']);

        // ========================
        // 💼 MANAJEMEN LOWONGAN (OK)
        // ========================
        Route::resource('lowongan', LowonganController::class);
        
        // Rute Monitoring Aplikasi (Diperlukan untuk LowonganController)
        Route::get('lowongan/{lowongan}/aplikasi', [LowonganController::class, 'monitoringAplikasi'])->name('lowongan.monitoring');
        Route::post('lowongan/aplikasi/{aplikasidata}/proses', [LowonganController::class, 'prosesAplikasi'])->name('lowongan.proses_aplikasi');
        
        // Data Mahasiswa
        Route::resource('datamahasiswa', DataMahasiswaController::class)->only(['index', 'show']);

    }); // END: Grup Prefix BPDPKS


}); // END: Grup Middleware AUTH


// ============================================
    // ROUTES KHUSUS ADMIN (FULL CONTROL)
    // ============================================
    // Menggunakan alias string jika sudah didaftarkan di bootstrap/app.php
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // 1. Dashboard Admin
        // PERBAIKAN UTAMA: Mengubah rute '/' menjadi '/dashboard' agar URL menjadi /admin/dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Redirect: Agar akses /admin tetap mengarah ke /admin/dashboard
        Route::redirect('/', 'dashboard'); 

        // Rute Logout Admin harus menggunakan AuthController::logout yang sudah didefinisikan di grup 'auth'
        // Jika perlu rute logout terpisah, pastikan AdminDashboardController memiliki method logout.
        // Jika tidak, hapus rute ini dan gunakan rute logout umum di atas. 
        // Saya asumsikan Anda ingin menggunakan rute logout umum, jadi saya hapus rute logout di sini.
        // Route::post('/logout', [AdminDashboardController::class, 'logout'])->name('logout'); // <-- DIHAPUS

        // 2. Manajemen Kampus (Admin memverifikasi dokumen MoU)
        Route::resource('kampus', AdminKampusController::class);
        
        // 3. Manajemen Mahasiswa & Akademik
        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            // Daftar Mahasiswa (CRUD data diri dasar)
            Route::resource('data', AdminMahasiswaController::class)->except(['show']); // Mengubah '/' menjadi 'data' untuk menghindari konflik rute
            
            // Data Akademik / Nilai (Mass Upload & Manual Input) - Menggunakan AdminMahasiswaAkademikController
            Route::prefix('akademik')->name('akademik.')->group(function () {
                // Tampilkan daftar nilai akademik seluruh mahasiswa
                Route::get('/', [AdminMahasiswaAkademikController::class, 'index'])->name('index'); 
                // Tampilkan form edit (Perbaikan di sini)
                Route::get('{mahasiswaDetail}/edit', [AdminMahasiswaAkademikController::class, 'edit'])->name('edit'); // <-- DITAMBAHKAN
                // Manual Input/Update Nilai (IPS/IPK)
                // Menggunakan ID MahasiswaDetail untuk create (MahasiswaDetail \$mahasiswaDetail)
                Route::get('create/{mahasiswaDetail}', [AdminMahasiswaAkademikController::class, 'create'])->name('create');
                Route::post('store', [AdminMahasiswaAkademikController::class, 'store'])->name('store');
                // Proses update data (Perbaikan di sini)
                Route::put('{mahasiswaDetail}', [AdminMahasiswaAkademikController::class, 'update'])->name('update'); // <-- DITAMBAHKAN
                // Mass Upload (Import)
                Route::get('import', [AdminMahasiswaAkademikController::class, 'showImportForm'])->name('import.form');
                Route::post('import', [AdminMahasiswaAkademikController::class, 'import'])->name('import.process'); 
            });

            // Manajemen Dokumen Mahasiswa (Verifikasi) - Menggunakan AdminMahasiswaDokumenController
            Route::prefix('dokumen')->name('dokumen.')->group(function () {
                Route::get('/', [AdminMahasiswaDokumenController::class, 'index'])->name('index');
                Route::get('{mahasiswaDetail}', [AdminMahasiswaDokumenController::class, 'show'])->name('show');
                Route::post('{mahasiswaDetail}/verifikasi', [AdminMahasiswaDokumenController::class, 'verifikasi'])->name('verifikasi'); 
            });


            // Data Akademik / Nilai (Mass Upload & OLAP Report) - Rute lama, dipertahankan jika Controller AdminNilaiController masih relevan
            Route::get('nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');
            Route::post('nilai/upload', [AdminNilaiController::class, 'massUpload'])->name('nilai.mass_upload'); 
            Route::get('nilai/report', [AdminNilaiController::class, 'reportOlap'])->name('nilai.olap'); 
        });

        // 4. Manajemen Program Beasiswa & Pengumuman - Menggunakan DataBeasiswaController
        // Catatan: Mengganti AdminBeasiswaController dengan DataBeasiswaController
        Route::resource('beasiswa', DataBeasiswaController::class); 
        
        // 5. Manajemen Lowongan Magang/Kerja & Penelitian/Lomba
        Route::resource('lowongan', AdminMagangLowonganController::class); // Rute untuk Lowongan
        Route::resource('penelitian-lomba', PenelitianLombaController::class); // Rute untuk Penelitian/Lomba
        
        // 6. Manajemen Registrasi Ulang & Feedback
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
        
        // 8. Notifikasi dan Pengumuman - Menggunakan AdminNotifikasiController
        Route::resource('notifikasi-pengumuman', AdminNotifikasiController::class)->names('notifikasi'); 

    });
    // END: Grup Prefix Admin