@extends('layouts.mahasiswa.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-green-900 mb-6">Daftar Lowongan Kerja</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($lowongans as $lowongan)
        <div class="bg-white p-5 shadow border border-green-200 rounded-lg">
            <h2 class="font-bold text-lg text-green-900">{{ $lowongan->judul }}</h2>
            <p class="text-green-700">{{ $lowongan->perusahaan }}</p>
            <p class="text-sm text-green-600">Diposting: {{ $lowongan->tanggal_post }}</p>

            <div class="mt-3">
                <a href="{{ route('mahasiswa.lowongankerja.show', $lowongan->id) }}"
                   class="px-3 py-1 bg-green-700 text-white rounded">Detail & Lamar</a>
            </div>
        </div>
        @empty
            <p class="text-gray-500 italic">Belum ada lowongan.</p>
        @endforelse
    </div>
</div>
@endsection
