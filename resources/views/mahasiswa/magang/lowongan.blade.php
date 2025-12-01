@extends('mahasiswa.layouts.app')
@section('title', 'Lowongan Magang')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8 bg-gradient-to-br from-green-50 to-white min-h-screen">
    <h1 class="text-4xl font-extrabold text-green-900 mb-8 text-center tracking-tight">Lowongan Magang</h1>

    @forelse ($lowongan as $item)
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-green-100 mb-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 ease-in-out transform">
            <h2 class="text-2xl font-bold text-green-900 mb-2">{{ $item->judul }}</h2>
            <p class="text-green-700 font-medium mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 2a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                {{ $item->perusahaan }} - {{ $item->lokasi ?? 'Remote' }}
            </p>
            <p class="text-green-800 mt-4 leading-relaxed">{{ \Illuminate\Support\Str::limit($item->deskripsi, 150) }}</p>
            <a href="{{ route('mahasiswa.magang.index') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                <span>Ajukan Magang</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    @empty
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <p class="text-green-700 text-lg font-medium">Belum ada lowongan magang tersedia.</p>
        </div>
    @endforelse
</div>
@endsection
