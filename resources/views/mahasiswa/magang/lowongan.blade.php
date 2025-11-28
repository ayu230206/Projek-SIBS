@extends('layouts.mahasiswa.app')
@section('title', 'Lowongan Magang')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-green-900 mb-6">Lowongan Magang</h1>

    @forelse ($lowongan as $item)
        <div class="bg-white p-6 rounded-xl shadow border border-green-200 mb-4">
            <h2 class="text-2xl font-semibold text-green-900">{{ $item->judul }}</h2>
            <p class="text-green-700">{{ $item->perusahaan }} - {{ $item->lokasi ?? 'Remote' }}</p>
            <p class="text-green-800 mt-2">{{ \Illuminate\Support\Str::limit($item->deskripsi, 150) }}</p>
            <a href="{{ route('mahasiswa.magang.lowongan.show', $item->id) }}" class="text-green-700 mt-2 inline-block hover:underline">Selengkapnya</a>
        </div>
    @empty
        <p class="text-green-700">Belum ada lowongan magang tersedia.</p>
    @endforelse
</div>
@endsection
