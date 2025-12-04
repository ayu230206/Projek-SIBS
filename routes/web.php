<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminKampusController;
// ============================================
// MAHASISWA Controllers
// ============================================
use App\Http\Controllers\Admin\AdminKeuanganController;
use App\Http\Controllers\Admin\AdminMagangLowonganController;
use App\Http\Controllers\Admin\AdminMahasiswaAkademikController;
use App\Http\Controllers\Admin\AdminMahasiswaController;
use App\Http\Controllers\Admin\AdminMahasiswaDokumenController;
use App\Http\Controllers\Admin\AdminNilaiController;
use App\Http\Controllers\Admin\AdminNotifikasiController;
use App\Http\Controllers\Admin\AdminRegisUlangController;
use App\Http\Controllers\Admin\DataBeasiswaController;
use App\Http\Controllers\Admin\PenelitianLombaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bpdpks\DataMahasiswaController;
use App\Http\Controllers\Bpdpks\FeedbackController as BpdpksFeedbackController;
use App\Http\Controllers\Admin\UserManagementController;
// ============================================
// BPDPKS Controllers
// ============================================
use App\Http\Controllers\Bpdpks\InfoKeuanganController;
use App\Http\Controllers\Bpdpks\KampusKerjasamaController;
use App\Http\Controllers\Bpdpks\LowonganController;
use App\Http\Controllers\Mahasiswa\BankJudulProyekController;
// BPDPKS Middleware
use App\Http\Controllers\Mahasiswa\CommentController; // <-- Pastikan ini sudah Anda buat!
// ============================================
// admin Controllers
// ============================================
use App\Http\Controllers\Mahasiswa\DashboardController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\FeedbackController as MahasiswaFeedbackController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\LikeController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\LowonganKerjaController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\LowonganMagangController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\MagangController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\MahasiswaAkademikController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\MahasiswaProfileController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\NotifikasiController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\PostController; // <-- DITAMBAHKAN
use App\Http\Controllers\Mahasiswa\ProyekAkhirController; // <-- DITAMBAHKAN
use App\Http\Middleware\IsBpdpks; // <-- DITAMBAHKAN
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDataMahasiswaController;
// ============================================
// 1. ROOT & AUTH ROUTES
// ============================================

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'mahasiswa') {
            return redirect()->route('dashboard'); // Default ke dashboard Mahasiswa (URL: /dashboard)

            return redirect()->route('dashboard');
        } elseif ($role == 'bpdpks') {
            return redirect()->route('bpdpks.dashboard'); // URL: /bpdpks/dashboard
        } elseif ($role == 'admin') {
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

}); // END: Grup Prefix Mahasiswa

// ---
// ROUTES BPDPKS
// ---
// Menggunakan alias string jika sudah didaftarkan di bootstrap/app.php
Route::middleware(['bpdpks'])->prefix('bpdpks')->name('bpdpks.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DataMahasiswaController::class, 'dashboard'])->name('dashboard');

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

        Route::resource('feedback', BpdpksFeedbackController::class)->only(['index', 'show']);
    });
});

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

    // Route Khusus Update Logo
    Route::post('/update-logo', [App\Http\Controllers\Admin\AdminDashboardController::class, 'updateLogo'])->name('logo.update');
    // Route untuk Membuka Halaman Pengaturan
    Route::get('/pengaturan', [AdminDashboardController::class, 'settings'])->name('settings');

     // a. Route Khusus untuk Tambah Mahasiswa Otomatis (HARUS DI ATAS Resource 'users')
    // URL: /admin/users/create-mahasiswa
    Route::get('/users/create-mahasiswa', [UserManagementController::class, 'createMahasiswa'])->name('users.create_mahasiswa');
    Route::post('/users/store-mahasiswa', [UserManagementController::class, 'storeMahasiswa'])->name('users.store_mahasiswa');

    // b. Route Resource Standar (List User, Create Admin, Edit, Delete)
    // Otomatis membuat route bernama: admin.users.index, admin.users.store, dll.
    Route::resource('users', UserManagementController::class);

    // Rute Logout Admin harus menggunakan AuthController::logout yang sudah didefinisikan di grup 'auth'
    // Jika perlu rute logout terpisah, pastikan AdminDashboardController memiliki method logout.
    // Jika tidak, hapus rute ini dan gunakan rute logout umum di atas.
    // Saya asumsikan Anda ingin menggunakan rute logout umum, jadi saya hapus rute logout di sini.
    // Route::post('/logout', [AdminDashboardController::class, 'logout'])->name('logout'); // <-- DIHAPUS

    // 2. Manajemen Kampus (Admin memverifikasi dokumen MoU)
    Route::resource('kampus', AdminKampusController::class)->parameters([
    'kampus' => 'kampus' // Memaksa nama parameter jadi {kampus}
]);

    // 3. Manajemen Mahasiswa & Akademik
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        // Daftar Mahasiswa (CRUD data diri dasar)
        Route::resource('data', AdminDataMahasiswaController::class); // Mengubah '/' menjadi 'data' untuk menghindari konflik rute

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