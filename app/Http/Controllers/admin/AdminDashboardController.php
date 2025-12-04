<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk administrator.
     */
    public function index()
    {
        // Data Dummy untuk Statistik Dashboard bertema Sawit
        $stats = [
            'total_mahasiswa' => 540,
            'mahasiswa_aktif' => 495,
            'dana_tersalurkan' => 'Rp 12.5 Miliar',
            'kampus_kerjasama' => 12,
            'lowongan_magang_aktif' => 8,
            'dokumen_perlu_verifikasi' => 45,
        ];

        // Data Dummy untuk Notifikasi / Pemberitahuan Terbaru
        $notifications = [
            ['title' => 'Dokumen MoU Kampus "X" perlu diverifikasi.', 'time' => '3 menit yang lalu', 'link' => route('admin.kampus.index')],
            ['title' => 'Pengajuan Beasiswa Tahap II ditutup.', 'time' => '1 jam yang lalu', 'link' => '#'],
            ['title' => 'Ada 15 dokumen akademik baru yang diunggah.', 'time' => '4 jam yang lalu', 'link' => route('admin.mahasiswa.dokumen.index')],
            ['title' => 'Feedback baru dari Mahasiswa Angkatan 2023.', 'time' => '1 hari yang lalu', 'link' => route('admin.regis-ulang.feedback')],
        ];
        
        // Asumsi data user sudah ada, termasuk nama
        $adminName = Auth::user()->name ?? 'Administrator';

        return view('admin.Dashboard', compact('stats', 'notifications', 'adminName'));
    }
    
}