<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Admin\PenelitianLomba;

class InfoLombaController extends Controller
{
    public function index()
    {
        // ✅ Hanya ambil data dengan tipe = lomba
        $lombas = PenelitianLomba::where('tipe', 'lomba')
                    ->latest()
                    ->get();

        return view('mahasiswa.info-lomba.index', compact('lombas'));
    }
}
