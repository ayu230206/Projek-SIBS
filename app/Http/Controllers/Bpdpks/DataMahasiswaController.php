<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
// Perbaikan 1: Ganti import MahasiswaDetail ke namespace yang benar: App\Models\MahasiswaDetail
use App\Models\MahasiswaDetail; 
use App\Models\Bpdpks\Kampus; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataMahasiswaController extends Controller
{
    /**
     * Menampilkan dashboard OLAP Data Mahasiswa dan daftar detail.
     */
    public function index(Request $request)
    {
        // Mendapatkan data untuk tabel detail
        $query = MahasiswaDetail::with(['user', 'kampus']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', $search);
            })->orWhereHas('kampus', function ($q) use ($search) {
                // Perlu dicek apakah Kampus di-load atau Kampus sudah memiliki relasi di MahasiswaDetail
                $q->where('nama_kampus', 'like', $search);
            })->orWhere('nim', 'like', $search);
        }

        // Filter Kampus 
        if ($request->filled('kampus_id')) {
            $query->where('kampus_id', $request->kampus_id);
        }

        // Ambil data dengan pagination
        $dataMahasiswa = $query->latest()->paginate(10); 
        
        // Ambil semua kampus untuk filter
        $allKampus = Kampus::orderBy('nama_kampus')->get();

        return view('bpdpks.datamahasiswa.index', compact('dataMahasiswa', 'allKampus'));
    }

    /**
     * Menampilkan detail Mahasiswa (OLAP - View Detail)
     * Menggunakan Route Model Binding, memastikan MahasiswaDetail diambil dari ID di URL.
     */
    // Perbaikan 2: Pastikan MahasiswaDetail di sini juga menggunakan model dari namespace yang benar
    public function show(MahasiswaDetail $mahasiswa)
    {
        // Pastikan relasi user dan kampus di-load
        $mahasiswa->load(['user', 'kampus']);
        
        // Jika Anda ingin menampilkan riwayat keuangan
        // Pastikan model User memiliki relasi ke Keuangan (misal: hasMany(\App\Models\Keuangan::class))
        // $riwayatKeuangan = $mahasiswa->user->keuangan; 

        return view('bpdpks.datamahasiswa.show', compact('mahasiswa'));
    }
}