@extends('mahasiswa.layouts.app')
@section('title', $lowongan->judul)

@section('content')

<div class="min-h-screen bg-gray-50 max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-8">
        <div class="flex justify-between items-start border-b pb-4 mb-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $lowongan->judul }}</h1>
                <p class="text-sm text-gray-500">Diposting oleh: {{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin BPDPKS' }}</p>
            </div>
            <div class="text-right">
                <span class="text-lg font-bold text-red-600">Deadline:</span>
                <p class="text-xl font-bold @if($lowongan->deadline < now()) text-red-600 @else text-green-600 @endif">
                    {{ $lowongan->deadline ? \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') : 'Tidak Ada' }}
                </p>
            </div>
        </div>

        @if ($sudahMelamar)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold"><i class="fas fa-check-circle mr-2"></i> Anda Sudah Melamar Lowongan Ini</p>
                <p class="text-sm">Silakan cek status aplikasi Anda di **Portal Magang**.</p>
            </div>
        @elseif ($lowongan->deadline && $lowongan->deadline < now())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Maaf, Lowongan Ini Sudah Ditutup</p>
            </div>
        @else
            <form action="{{ route('mahasiswa.magang.lowongan.apply', $lowongan->id) }}" method="POST" class="mb-6">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-150 text-lg shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i> Ajukan Lamaran Sekarang
                </button>
            </form>
        @endif

        <h2 class="text-2xl font-semibold text-gray-800 border-b mt-6 pb-2 mb-4">Deskripsi Magang</h2>
        <div class="prose max-w-none text-gray-700 mb-6">
            {!! nl2br(e($lowongan->deskripsi)) !!}
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-4">Kualifikasi / Persyaratan</h2>
        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($lowongan->kualifikasi)) !!}
        </div>
        
        <div class="mt-8 pt-4 border-t">
            <a href="{{ route('mahasiswa.magang.lowongan') }}" class="text-gray-600 hover:text-gray-800 font-semibold">
                &larr; Kembali ke Daftar Lowongan
            </a>
        </div>
    </div>
</div>

@endsection