@extends('layouts.mahasiswa.app')

@section('title', $lowongan->judul)

@section('content')
<div class="p-6">

    <h1 class="text-3xl font-bold text-green-900">{{ $lowongan->judul }}</h1>
    <p class="text-lg text-green-700">{{ $lowongan->perusahaan }}</p>

    <div class="mt-4 bg-white p-5 border border-green-200 shadow rounded-lg">
        {!! nl2br(e($lowongan->deskripsi)) !!}
    </div>

    <h2 class="text-xl font-bold mt-8 mb-3 text-green-900">Lamar Pekerjaan</h2>

    <form action="{{ route('mahasiswa.lamaran.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-5 border border-green-200 shadow rounded-lg">
        @csrf

        <label class="font-semibold">Upload CV (PDF)</label>
        <input type="file" name="cv" accept="application/pdf" class="w-full p-2 border rounded mb-4" required>

        <label class="font-semibold">Portofolio (opsional)</label>
        <input type="file" name="portofolio" class="w-full p-2 border rounded mb-4">

        <button class="bg-green-800 text-white px-4 py-2 rounded-lg shadow">Kirim Lamaran</button>
    </form>

</div>
@endsection
