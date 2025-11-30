@extends('mahasiswa.layouts.app')
@section('title', 'Proyek Akhir')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 max-w-6xl mx-auto px-4 py-6">

    <div class="text-center mb-8">
        <h2 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mb-4">
            Proyek Akhir
        </h2>
        <p class="text-lg text-gray-600">Pilih menu di bawah ini untuk melihat daftar proyek Anda atau riwayat pendaftaran terkait Proyek Akhir.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- 1. Daftar Proyek (Mengarah ke Tabel Riwayat/Index) --}}
        <a href="{{ route('mahasiswa.proyek.index') }}" 
           class="bg-white border border-green-600 rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:bg-green-50 transition-all duration-300 flex items-center gap-6 group">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-700 group-hover:bg-green-200 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-xl text-green-800 group-hover:text-green-900 transition-colors duration-300">Daftar Proyek Dan Riwayat Pengajuan Proyek</h3>
                <p class="text-sm text-gray-600 mt-1">Kelola, tambah, dan hapus data Proyek Akhir yang Anda miliki.</p>
            </div>
        </a>

        <a href="#" 
           class="bg-white border border-blue-600 rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:bg-blue-50 transition-all duration-300 flex items-center gap-6 group">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 group-hover:bg-blue-200 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-xl text-blue-800 group-hover:text-blue-900 transition-colors duration-300"> Bank Judul Proyek Akhir</h3>
                <p class="text-sm text-gray-600 mt-1">Temukan Judul terkait Proyek Akhir Anda</p>
            </div>
        </a>

    </div>

</div>
@endsection