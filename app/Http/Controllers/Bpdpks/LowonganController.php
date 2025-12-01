<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
// --- PERBAIKAN DI SINI: Hapus 'Bpdpks\' dari path Model ---
use App\Models\Bpdpks\Lowongan;
use App\Models\Bpdpks\LowonganAplikasi;
 // Mengganti: use App\Models\Bpdpks\LowonganAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
// Pastikan Anda juga mengimpor Model User
use App\Models\User;

class LowonganController extends Controller
{
    // --- CRUD LOWONGAN/MAGANG (ADMIN VIEW) ---

    public function index(Request $request)
    {
        $tipe = $request->get('tipe', 'semua');
        $search = $request->get('search');

        $lowongans = Lowongan::withCount('aplikasi')
            ->orderBy('deadline', 'desc');

        if ($tipe != 'semua') {
            $lowongans->where('tipe', $tipe);
        }

        if ($search) {
            $lowongans->where('judul', 'like', '%' . $search . '%');
        }

        $lowongans = $lowongans->paginate(10)->withQueryString();

        // Mengambil data aplikasi yang masih berstatus 'diajukan' untuk ditampilkan di notifikasi
        $pendingAplikasiCount = LowonganAplikasi::where('status', 'diajukan')->count();

        return view('bpdpks.lowongan.index', compact('lowongans', 'tipe', 'search', 'pendingAplikasiCount'));
    }

    public function create()
    {
        return view('bpdpks.lowongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => ['required', Rule::in(['magang', 'lowongan_kerja'])],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        Lowongan::create([
            'tipe' => $request->tipe,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            // ID pengguna yang sedang login (harus admin/bpdpks)
            'diinput_oleh_id' => Auth::id(), 
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('bpdpks.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil ditambahkan!');
    }

    public function edit(Lowongan $lowongan)
    {
        return view('bpdpks.lowongan.edit', compact('lowongan'));
    }

    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'tipe' => ['required', Rule::in(['magang', 'lowongan_kerja'])],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kualifikasi' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $lowongan->update($request->only(['tipe', 'judul', 'deskripsi', 'kualifikasi', 'deadline']));

        return redirect()->route('bpdpks.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil diperbarui!');
    }

    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();
        return redirect()->route('bpdpks.lowongan.index')->with('success', 'Data Lowongan/Magang berhasil dihapus!');
    }
    
    // --- MONITORING APLIKASI ---

    public function monitoringAplikasi(Request $request, Lowongan $lowongan)
    {
        $status = $request->get('status', 'semua');

        $aplikasis = $lowongan->aplikasi()->with('mahasiswa')
            ->orderBy('created_at', 'desc');

        if ($status != 'semua') {
            $aplikasis->where('status', $status);
        }

        $aplikasis = $aplikasis->paginate(10)->withQueryString();

        return view('bpdpks.lowongan.monitoring_aplikasi', compact('lowongan', 'aplikasis', 'status'));
    }

    public function prosesAplikasi(Request $request, LowonganAplikasi $aplikasidata)
    {
        $request->validate([
            'status' => ['required', Rule::in(['diterima', 'ditolak'])],
            'catatan_admin' => 'nullable|string',
        ]);

        $aplikasidata->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()->with('success', 'Status aplikasi berhasil diperbarui!');
    }
}