<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        // Tandai semua notifikasi yang belum dibaca sebagai sudah dibaca saat halaman dibuka
        Auth::user()->unreadNotifications->markAsRead();

        // Ambil data notifikasi
        $notifikasi = Auth::user()->notifications;

        return view('mahasiswa.notifikasi.index', compact('notifikasi'));
    }
}
