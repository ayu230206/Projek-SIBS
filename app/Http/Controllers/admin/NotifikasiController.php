<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Asumsi Anda memiliki Model untuk Notifikasi yang bisa dilihat di dashboard
use App\Models\Notifikasi; // Perlu dibuat Model Notifikasi dan Migrasinya

class NotifikasiController extends Controller
{
    /**
     * Tampilkan daftar Notifikasi/Pengumuman yang sudah dikirim.
     * Role: Admin
     */
    public function index()
    {
        $notifikasis = Notifikasi::latest()->paginate(10);
        return view('admin.Notifikasi dan Pengumuman.index', compact('notifikasis'));
    }

    /**
     * Tampilkan formulir untuk membuat pengumuman baru.
     * Role: Admin
     */
    public function create()
    {
        return view('admin.Notifikasi dan Pengumuman.create');
    }

    /**
     * Simpan Notifikasi/Pengumuman baru dan kirim ke Mahasiswa.
     * Role: Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'jenis' => 'required|in:umum,pencairan,registrasi_ulang', // Contoh jenis notifikasi
        ]);

        // Simpan ke database
        $notifikasi = Notifikasi::create(array_merge($request->all(), [
            'user_id_pengirim' => auth()->id(), // Admin yang mengirim
        ]));
        
        // TODO: Logika untuk mengirim notifikasi ke Mahasiswa (misalnya melalui Broadcast atau Job Queue)
        // KirimNotifikasiToMahasiswaJob::dispatch($notifikasi); 

        return redirect()->route('admin.notifikasi.index')->with('success', 'Pengumuman berhasil dibuat dan dikirim ke dashboard Mahasiswa.');
    }

    /**
     * Tampilkan formulir edit Notifikasi/Pengumuman.
     * Role: Admin
     */
    public function edit(Notifikasi $notifikasi)
    {
        return view('admin.Notifikasi dan Pengumuman.edit', compact('notifikasi'));
    }

    /**
     * Perbarui Notifikasi/Pengumuman yang sudah ada.
     * Role: Admin
     */
    public function update(Request $request, Notifikasi $notifikasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'jenis' => 'required|in:umum,pencairan,registrasi_ulang',
        ]);

        $notifikasi->update($request->all());

        return redirect()->route('admin.notifikasi.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Hapus Notifikasi/Pengumuman.
     * Role: Admin
     */
    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}