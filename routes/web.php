<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- CONTROLLERS ADMIN ---
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminKampusController;
use App\Http\Controllers\Admin\AdminKeuanganController;
use App\Http\Controllers\Admin\AdminMagangLowonganController;
use App\Http\Controllers\Admin\AdminMahasiswaAkademikController;
use App\Http\Controllers\Admin\AdminMahasiswaDokumenController;
use App\Http\Controllers\Admin\AdminNilaiController; // Jika masih dipakai
use App\Http\Controllers\Admin\AdminNotifikasiController;
use App\Http\Controllers\Admin\AdminRegisUlangController;
use App\Http\Controllers\Admin\DataBeasiswaController;
use App\Http\Controllers\Admin\PenelitianLombaController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminDataMahasiswaController;
use App\Http\Controllers\Admin\AdminForumController; // <-- PASTIKAN CONTROLLER INI SUDAH DIBUAT

// --- CONTROLLERS BPDPKS ---
use App\Http\Controllers\Bpdpks\DataMahasiswaController;
use App\Http\Controllers\Bpdpks\FeedbackController as BpdpksFeedbackController;
use App\Http\Controllers\Bpdpks\InfoKeuanganController;
use App\Http\Controllers\Bpdpks\KampusKerjasamaController;
use App\Http\Controllers\Bpdpks\LowonganController; // Controller BPDPKS

// --- CONTROLLERS MAHASISWA ---
use App\Http\Controllers\Mahasiswa\BankJudulProyekController;
use App\Http\Controllers\Mahasiswa\CommentController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\FeedbackController as MahasiswaFeedbackController;
use App\Http\Controllers\Mahasiswa\LikeController;
use App\Http\Controllers\Mahasiswa\LowonganKerjaController;
use App\Http\Controllers\Mahasiswa\LowonganMagangController;
use App\Http\Controllers\Mahasiswa\MagangController;
use App\Http\Controllers\Mahasiswa\MahasiswaAkademikController;
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController;
use App\Http\Controllers\Mahasiswa\NotifikasiController;
use App\Http\Controllers\Mahasiswa\PostController;
use App\Http\Controllers\Mahasiswa\ProyekAkhirController;
use App\Http\Controllers\Mahasiswa\InfoLombaController;
use App\Http\Controllers\Mahasiswa\PenelitianController;

// --- CONTROLLERS AUTH ---
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// 1. ROOT & AUTHENTICATION
// ============================================

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        } elseif ($role == 'bpdpks') {
            return redirect()->route('bpdpks.dashboard');
        } elseif ($role == 'admin') {
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

    Route::get('/auth/google/redirect', [AuthController::class, 'googleRedirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ============================================
// 2. MAHASISWA ROUTES
// ============================================
Route::middleware(['auth', 'mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Forum (Posts, Likes, Comments, Share)
    Route::resource('posts', PostController::class);
    Route::post('posts/{post_id}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::delete('posts/{post_id}/like', [LikeController::class, 'destroy'])->name('posts.unlike');
    Route::post('posts/{post_id}/comment', [CommentController::class, 'store'])->name('posts.comment.store');
    Route::delete('posts/comment/{comment_id}', [CommentController::class, 'destroy'])->name('posts.comment.destroy');
    Route::post('posts/{post}/share', [PostController::class, 'share'])->name('posts.share');

    // Profil
    Route::get('profil', [MahasiswaProfileController::class, 'index'])->name('profil.index');
    Route::get('profil/edit', [MahasiswaProfileController::class, 'edit'])->name('profil.edit');
    Route::put('profil', [MahasiswaProfileController::class, 'update'])->name('profil.update');

    // Proyek Akhir & Bank Judul
    Route::prefix('proyek')->name('proyek.')->group(function () {
        Route::get('/dashboard', [ProyekAkhirController::class, 'menu'])->name('dashboard');
        Route::get('/', [ProyekAkhirController::class, 'index'])->name('index');
        Route::post('/', [ProyekAkhirController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProyekAkhirController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProyekAkhirController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProyekAkhirController::class, 'destroy'])->name('destroy');
        Route::get('/bankjudul', [BankJudulProyekController::class, 'index'])->name('bankjudul');
    });

    // Magang
    Route::prefix('magang')->name('magang.')->group(function () {
        Route::get('/dashboard', function () { return view('mahasiswa.magang.dashboard'); })->name('dashboard');
        Route::get('/riwayat', [MagangController::class, 'index'])->name('riwayat');
        Route::get('/', [MagangController::class, 'index'])->name('index');
        Route::get('/ajukan', function () { return view('mahasiswa.magang.ajukan'); })->name('ajukan');
        Route::post('/store', [MagangController::class, 'store'])->name('store');

<<<<<<< HEAD
    // Rute default /dashboard dialihkan ke /mahasiswa/dashboard, jika autentikasi berhasil
    Route::redirect('/dashboard', '/mahasiswa/dashboard');

}); // END: Grup Prefix Mahasiswa

// ============================================
// 3. ROUTES BPDPKS (Menggunakan satu blok yang benar)
// ============================================
// Menggunakan alias string jika sudah didaftarkan di bootstrap/app.php
Route::middleware(['bpdpks'])
    ->prefix('bpdpks')
    ->name('bpdpks.')
    ->group(function () {

        // 1. Dashboard (URL: /bpdpks/dashboard, Name: bpdpks.dashboard)
        Route::get('/dashboard', [DataMahasiswaController::class, 'dashboard'])->name('dashboard');

        // 2. Data Mahasiswa (URL: /bpdpks/data-mahasiswa, Name: bpdpks.datamahasiswa.index)
        // Rute terpisah untuk index/list data mahasiswa agar resource di bawah tidak menimpanya
        Route::get('/data-mahasiswa', [DataMahasiswaController::class, 'index'])->name('datamahasiswa.index');

        // Route API untuk chart
        Route::get('/chart-data-api', [DataMahasiswaController::class, 'getChartDataApi'])->name('chartdata.api');

        // Resource Keuangan, Kerjasama, Lowongan
        Route::resource('keuangan', InfoKeuanganController::class)->except(['show']);
        Route::resource('kerjasama', KampusKerjasamaController::class)->except(['show']);
        Route::resource('lowongan', LowonganController::class);

        // Monitoring dan Proses Aplikasi Lowongan
        Route::get('lowongan/{lowongan}/aplikasi', [LowonganController::class, 'monitoringAplikasi'])->name('lowongan.monitoring');
        Route::post('lowongan/aplikasi/{aplikasidata}/proses', [LowonganController::class, 'prosesAplikasi'])->name('lowongan.proses_aplikasi');
     Route::get('lowongan/aplikasi/{aplikasi}', 
    [LowonganController::class, 'detailAplikasi']
)->name('lowongan.aplikasi.show');


        // Resource Data Mahasiswa (Hanya Show, karena Index sudah di atas)
        // URL: /bpdpks/datamahasiswa/{datamahasiswa}, Name: bpdpks.datamahasiswa.show
        Route::resource('datamahasiswa', DataMahasiswaController::class)->only(['show']);

        // Resource Feedback
        Route::resource('feedback', BpdpksFeedbackController::class)->only(['index', 'show']);
=======
        // Lowongan Magang (Spesifik BPDPKS)
        Route::get('/lowongan', [LowonganMagangController::class, 'index'])->name('lowongan');
        Route::get('/lowongan/{lowongan}', [LowonganMagangController::class, 'show'])->name('lowongan.show');
        Route::post('/lowongan/{lowongan}/apply', [LowonganMagangController::class, 'apply'])->name('lowongan.apply');
>>>>>>> 5ffacd8b772c7966c5ab86c012b6568d5b89bd69
    });

    // Lowongan Kerja (Umum)
    Route::prefix('lowongankerja')->name('lowongankerja.')->group(function () {
        Route::get('/', [LowonganKerjaController::class, 'index'])->name('index');
        Route::get('/riwayat', [LowonganKerjaController::class, 'riwayat'])->name('riwayat');
        Route::get('/{id}', [LowonganKerjaController::class, 'show'])->name('show');
        Route::post('/{id}/lamar', [LowonganKerjaController::class, 'lamar'])->name('lamaran.store');
    });

    // Akademik
    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::get('/dashboard', [MahasiswaAkademikController::class, 'dashboard'])->name('dashboard');
        Route::get('/upload', [MahasiswaAkademikController::class, 'uploadPage'])->name('upload.page');
        Route::post('/upload', [MahasiswaAkademikController::class, 'uploadDokumen'])->name('upload');
        Route::delete('/dokumen/{dokumen}', [MahasiswaAkademikController::class, 'destroyDokumen'])->name('dokumen.destroy');
        Route::get('/ipk', [MahasiswaAkademikController::class, 'ipk'])->name('ipk');
    });

    // Feedback
    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/', [MahasiswaFeedbackController::class, 'index'])->name('index');
        Route::post('/', [MahasiswaFeedbackController::class, 'store'])->name('store');
    });

    // Notifikasi
    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::delete('notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    Route::delete('notifikasi', [NotifikasiController::class, 'destroyAll'])->name('notifikasi.destroyAll');

    // Info Lomba & Penelitian
    Route::get('/info-lomba', [InfoLombaController::class, 'index'])->name('info-lomba');
    Route::get('/penelitian', [PenelitianController::class, 'index'])->name('penelitian');
});


// ============================================
// 3. BPDPKS ROUTES
// ============================================
Route::middleware(['auth', 'bpdpks'])->prefix('bpdpks')->name('bpdpks.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DataMahasiswaController::class, 'dashboard'])->name('dashboard');

    // Data Mahasiswa (OLAP)
    Route::get('/data-mahasiswa', [DataMahasiswaController::class, 'index'])->name('datamahasiswa.index');
    Route::get('/chart-data-api', [DataMahasiswaController::class, 'getChartDataApi'])->name('chartdata.api');
    Route::resource('datamahasiswa', DataMahasiswaController::class)->only(['show']);

    // Keuangan & Kerjasama
    Route::resource('keuangan', InfoKeuanganController::class)->except(['show']);
    Route::resource('kerjasama', KampusKerjasamaController::class)->except(['show']);

    // Lowongan (Monitoring & Proses)
    Route::get('lowongan/{lowongan}/aplikasi', [LowonganController::class, 'monitoringAplikasi'])->name('lowongan.monitoring');
    Route::post('lowongan/aplikasi/{aplikasidata}/proses', [LowonganController::class, 'prosesAplikasi'])->name('lowongan.proses_aplikasi');
    Route::resource('lowongan', LowonganController::class);

    // Feedback
    Route::resource('feedback', BpdpksFeedbackController::class)->only(['index', 'show']);
});


// ============================================
// 4. ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard & Settings
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::redirect('/', 'dashboard');
    Route::post('/update-logo', [AdminDashboardController::class, 'updateLogo'])->name('logo.update');
    Route::get('/pengaturan', [AdminDashboardController::class, 'settings'])->name('settings');

    // 2. User Management
    Route::get('/users/create-mahasiswa', [UserManagementController::class, 'createMahasiswa'])->name('users.create_mahasiswa');
    Route::post('/users/store-mahasiswa', [UserManagementController::class, 'storeMahasiswa'])->name('users.store_mahasiswa');
    Route::resource('users', UserManagementController::class);

    // 3. Kampus
    Route::resource('kampus', AdminKampusController::class)->parameters(['kampus' => 'kampus']);

    // 4. Manajemen Mahasiswa (Data & Akademik & Dokumen)
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        // CRUD Data Diri
        Route::resource('data', AdminDataMahasiswaController::class);

        // Akademik (Nilai)
        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/', [AdminMahasiswaAkademikController::class, 'index'])->name('index');
            Route::get('{mahasiswaDetail}/edit', [AdminMahasiswaAkademikController::class, 'edit'])->name('edit');
            Route::put('{mahasiswaDetail}', [AdminMahasiswaAkademikController::class, 'update'])->name('update');
            Route::get('create/{mahasiswaDetail}', [AdminMahasiswaAkademikController::class, 'create'])->name('create');
            Route::post('store', [AdminMahasiswaAkademikController::class, 'store'])->name('store');
            Route::get('import', [AdminMahasiswaAkademikController::class, 'showImportForm'])->name('import.form');
            Route::post('import', [AdminMahasiswaAkademikController::class, 'import'])->name('import.process');
        });

        // Dokumen (Verifikasi)
        Route::prefix('dokumen')->name('dokumen.')->group(function () {
            Route::get('/', [AdminMahasiswaDokumenController::class, 'index'])->name('index');
            Route::get('{mahasiswaDetail}', [AdminMahasiswaDokumenController::class, 'show'])->name('show');
            Route::post('{mahasiswaDetail}/verifikasi', [AdminMahasiswaDokumenController::class, 'verifikasi'])->name('verifikasi');
        });
    });

    // 5. Program Beasiswa
    Route::resource('beasiswa', DataBeasiswaController::class);

    // 6. Lowongan (Monitoring & Proses) - PERBAIKAN: Route ini harus SEBELUM resource
    Route::get('lowongan/{id}/monitoring', [AdminMagangLowonganController::class, 'monitoringAplikasi'])->name('lowongan.monitoring');
    Route::post('lowongan/aplikasi/{aplikasi_id}/proses', [AdminMagangLowonganController::class, 'prosesAplikasi'])->name('lowongan.proses_aplikasi');
    Route::resource('lowongan', AdminMagangLowonganController::class);

    // 7. Penelitian & Lomba
    Route::resource('penelitian-lomba', PenelitianLombaController::class);

    // 8. Registrasi Ulang & Feedback
    Route::prefix('regis-ulang')->name('regis-ulang.')->group(function () {
        Route::get('/', [AdminRegisUlangController::class, 'index'])->name('index');
        Route::post('{regis_ulang_id}/approve', [AdminRegisUlangController::class, 'approve'])->name('approve');
        Route::post('{regis_ulang_id}/reject', [AdminRegisUlangController::class, 'reject'])->name('reject');
        Route::get('feedback', [AdminFeedbackController::class, 'index'])->name('feedback');
    });

    // 9. Keuangan
    Route::resource('keuangan', AdminKeuanganController::class)->except(['create']);
    Route::post('keuangan/{id}/transfer', [AdminKeuanganController::class, 'markAsTransferred'])->name('keuangan.transfer');

    // 10. Notifikasi
    Route::resource('notifikasi-pengumuman', AdminNotifikasiController::class)->names('notifikasi');

    // 11. Forum Moderasi (Baru)
    Route::resource('forum', AdminForumController::class)->only(['index', 'destroy']);
});