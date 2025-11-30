<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DokumenMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaDokumenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            'dokumen' => 'required|mimes:pdf,png,jpg,jpeg|max:2048'
        ]);

        $path = $request->file('dokumen')->store('dokumen_mahasiswa', 'public');

        DokumenMahasiswa::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Dokumen berhasil diupload.');
    }
}
