@extends('layouts.mahasiswa.app')
@section('title', ' Proyek Akhir')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

<h2 class="text-3xl font-extrabold mb-8 text-green-900"> Proyek Akhir</h2>
<p class="mb-6 text-gray-600">Pilih menu di bawah ini untuk melihat daftar proyek Anda atau riwayat pendaftaran terkait Proyek Akhir.</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- 1. Daftar Proyek (Mengarah ke Tabel Riwayat/Index) --}}
    <a href="{{ route('mahasiswa.proyek.index') }}" 
       class="bg-white border border-green-600 rounded-2xl p-6 shadow-lg hover:shadow-xl hover:bg-green-50 transition flex items-center gap-4">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-xl text-green-800">Daftar Proyek Dan Riwayat Pengajuan Proyek </h3>
            <p class="text-sm text-gray-600 mt-1">Kelola, tambah, dan hapus data Proyek Akhir yang Anda miliki.</p>
        </div>
    </a>

   


</div>
@endsection