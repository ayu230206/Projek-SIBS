<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaDetail;
use Illuminate\Http\Request;

class AdminMahasiswaDokumenController extends Controller
{
    // List mahasiswa yang dokumennya perlu verifikasi
    public function index()
    {
        // Asumsi: Ada status verifikasi di tabel atau kita cek kelengkapan
        $dataMahasiswa = MahasiswaDetail::with('user')->paginate(10);
        return view('admin.mahasiswa.dokumen.index', compact('dataMahasiswa'));
    }

    // Lihat detail dokumen spesifik
    public function show(MahasiswaDetail $mahasiswaDetail)
    {
        // Load relasi dokumen (Asumsi Anda punya model Dokumen atau field path di MahasiswaDetail)
        // $mahasiswaDetail->load('dokumen'); 
        return view('admin.mahasiswa.dokumen.show', compact('mahasiswaDetail'));
    }

    // Aksi Verifikasi (Terima/Tolak)
    public function verifikasi(Request $request, MahasiswaDetail $mahasiswaDetail)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string'
        ]);

        // Simpan status verifikasi (sesuaikan nama kolom di DB Anda)
        // $mahasiswaDetail->update([...]);

        return redirect()->back()->with('success', 'Status dokumen berhasil diperbarui.');
    }
}