<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa\LowonganMagang;

class LowonganMagangController extends Controller
{
    public function index()
    {
        $lowongan = LowonganMagang::latest()->get();
        return view('admin.mahasiswa.magang.lowongan', compact('lowongan'));
    }

    public function show($id)
    {
        $lowongan = LowonganMagang::findOrFail($id);
        return view('admin.mahasiswa.magang.lowongan_show', compact('lowongan'));
    }
}
