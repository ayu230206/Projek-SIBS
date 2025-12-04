<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MahasiswaDetail;

class MahasiswaDokumenController extends Controller
{
    /**
     * Tampilkan daftar mahasiswa dan status kelengkapan dokumen.
     * Role: Admin
     */
    public function index()
    {
        $mahasiswaDokumen = MahasiswaDetail::whereHas('user', function($query) {
            $query->where('role', 'mahasiswa');
        })->with('user')->paginate(20);
        
        return view('admin.mahasiswa.dokumen.index', compact('mahasiswaDokumen'));
    }

    /**
     * Tampilkan detail dokumen mahasiswa untuk diverifikasi.
     * Role: Admin
     */
    public function show(MahasiswaDetail $mahasiswaDetail)
    {
        // Logika untuk menampilkan link/preview dokumen
        return view('admin.mahasiswa.dokumen.show', compact('mahasiswaDetail'));
    }

    /**
     * Aksi untuk menandai dokumen sebagai verified/unverified (Opsional).
     * Role: Admin
     */
    public function verifikasi(Request $request, MahasiswaDetail $mahasiswaDetail)
    {
        $request->validate([
            'status_verifikasi_ktp' => 'nullable|boolean', // Tambahkan kolom status_verifikasi di migrasi jika diperlukan
        ]);

        // Logika Verifikasi
        // $mahasiswaDetail->update(['is_ktp_verified' => $request->status_verifikasi_ktp]);

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }
}