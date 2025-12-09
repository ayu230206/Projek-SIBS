<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bpdpks\Lowongan;
use App\Models\Bpdpks\LowonganAplikasi;
use App\Models\ActivityLog; // Pastikan model ini ada sesuai request sebelumnya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Import Facade File

class AdminMagangLowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::with('diinputOleh')->latest()->paginate(10);
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function show($id)
    {
        // 1. Ambil data lowongan berdasarkan ID

        $lowongan = Lowongan::findOrFail($id);

        // 2. Cek apakah mahasiswa yang login sudah melamar lowongan ini
        // Menggunakan model LowonganAplikasi (bukan Lamaran) karena ini untuk BPDPKS
        $sudahMelamar = LowonganAplikasi::where('lowongan_id', $lowongan->id)
                                        ->where('mahasiswa_id', auth()->id())
                                        ->exists();

        // 3. Kirim data ke View yang baru Anda buat
        return view('mahasiswa.magang.lowongan_show', compact('lowongan', 'sudahMelamar'));
    }

    public function create()
    {
        return view('admin.lowongan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:magang,lowongan_kerja',
            'deskripsi' => 'required',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'required|date',
            // Validasi file: gambar atau PDF, maks 2MB
            'file_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);

        $validated['diinput_oleh_id'] = Auth::id();
        $validated['status'] = 'aktif';

        // --- LOGIKA UPLOAD FILE ---
        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            // Nama file unik: waktu_namaasli
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Pindahkan ke public/uploads/lowongan
            $file->move(public_path('uploads/lowongan'), $filename);
            
            // Simpan path relatif ke database
            $validated['file_path'] = 'uploads/lowongan/' . $filename;
        }

        Lowongan::create($validated);

        // Catat Log (Opsional sesuai request no.1)
        if(class_exists(ActivityLog::class)) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Tambah Lowongan',
                'description' => Auth::user()->nama_lengkap . ' menambahkan: ' . $request->judul
            ]);
        }

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dipublish.');
    }

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        return view('admin.lowongan.edit', compact('lowongan'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:magang,lowongan_kerja',
            'deskripsi' => 'required',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'required|date',
            'file_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // --- LOGIKA UPLOAD FILE BARU ---
        if ($request->hasFile('file_pendukung')) {
            // 1. Hapus file lama jika ada
            if ($lowongan->file_path && File::exists(public_path($lowongan->file_path))) {
                File::delete(public_path($lowongan->file_path));
            }

            // 2. Upload file baru
            $file = $request->file('file_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lowongan'), $filename);
            
            $validated['file_path'] = 'uploads/lowongan/' . $filename;
        }

        $lowongan->update($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan diperbarui.');
    }

    public function destroy($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        // Hapus file fisik jika ada
        if ($lowongan->file_path && File::exists(public_path($lowongan->file_path))) {
            File::delete(public_path($lowongan->file_path));
        }

        $lowongan->delete();
        
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan dihapus.');
    }
}