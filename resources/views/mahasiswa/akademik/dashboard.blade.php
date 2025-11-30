@extends('mahasiswa.layouts.app')
@section('title', 'Dashboard Akademik')

@section('content')
<div class="bg-gradient-to-br from-green-100 via-blue-50 to-purple-100 min-h-screen py-12 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- IPS Semester --}}
        <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 text-center hover:shadow-3xl hover:scale-105 transition-all duration-300 ease-in-out border border-white/20">
            <div class="flex justify-center mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-700 mb-2">
                IPS Semester {{ $akademik->semester ?? '-' }}
            </h2>
            <p class="text-4xl font-extrabold text-green-600 mt-4">
                {{ $akademik && isset($akademik->ips[$akademik->semester]) ? $akademik->ips[$akademik->semester] : '-' }}
            </p>
        </div>

        {{-- IPK --}}
        <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 text-center hover:shadow-3xl hover:scale-105 transition-all duration-300 ease-in-out border border-white/20">
            <div class="flex justify-center mb-4">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-700 mb-2">IPK</h2>
            <p class="text-4xl font-extrabold text-blue-600 mt-4">
                {{ $akademik->ipk ?? '-' }}
            </p>
        </div>

        {{-- Upload Dokumen --}}
        <a href="{{ route('mahasiswa.akademik.upload.page') }}" class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl p-8 text-center hover:shadow-3xl hover:scale-105 transition-all duration-300 ease-in-out border border-white/20 block group">
            <div class="flex justify-center mb-4">
                <svg class="w-12 h-12 text-purple-600 group-hover:text-purple-800 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-700 mb-2 group-hover:text-gray-900 transition-colors">Upload Dokumen</h2>
            <p class="mt-4 text-gray-600 group-hover:text-gray-800 transition-colors">Klik untuk upload dokumen baru</p>
        </a>

    </div>
</div>
@endsection