<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\LowonganKerja;

class LowonganKerjaController extends Controller
{
    // Menampilkan daftar lowongan untuk mahasiswa
    public function index()
    {
        $lowongans = LowonganKerja::orderBy('tanggal_post', 'desc')->get();
        return view('mahasiswa.lowongankerja.index', compact('lowongans'));
    }

    // Menampilkan detail lowongan + form lamaran
    public function show($id)
    {
        $job = LowonganKerja::findOrFail($id);
        return view('mahasiswa.lowongankerja.show', compact('job'));
    }
}
