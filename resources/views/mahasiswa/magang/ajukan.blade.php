@extends('mahasiswa.layouts.app')
@section('title', 'Pendaftaran Magang')

@section('content')

<div class="min-h-screen bg-white max-w-5xl mx-auto py-10">

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-2xl text-center shadow-xl animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD FORM PENDAFTARAN --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-green-200 mb-12 overflow-hidden hover:shadow-3xl transition-shadow duration-300">

        <div class="px-8 py-6 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-xl flex items-center gap-3">
            <span class="text-3xl">📝</span> 
            @if(isset($lowongan))
                Lamar Lowongan: {{ $lowongan->judul }}
            @else
                Pendaftaran Magang
            @endif
        </div>

        <div class="p-8">

            {{-- FORM --}}
            <form 
                action="{{ isset($lowongan) 
                    ? route('mahasiswa.magang.lowongan.apply', $lowongan->id) 
                    : route('mahasiswa.magang.store') }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="space-y-6">

                @csrf

                {{-- ID Lowongan (wajib supaya apply() dapat ID) --}}
                @if(isset($lowongan))
                    <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                @endif

                {{-- Tempat Magang --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Tempat Magang</label>
                    <input type="text" 
                           name="tempat_magang" 
                           required
                           value="{{ isset($lowongan) ? $lowongan->judul : '' }}"
                           class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4"
                           @if(isset($lowongan)) readonly @endif>
                </div>

                {{-- Posisi --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Posisi</label>
                    <input type="text" 
                           name="posisi" 
                           required
                           value="{{ isset($lowongan) ? $lowongan->posisi : '' }}"
                           class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4"
                           @if(isset($lowongan)) readonly @endif>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4 min-h-[120px]"
                        @if(isset($lowongan)) readonly @endif>{{ isset($lowongan) ? $lowongan->deskripsi : '' }}</textarea>
                </div>

                {{-- Tanggal --}}
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Tanggal Mulai</label>
                        <input type="date" name="mulai"
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4">
                    </div>

                    <div>
                        <label class="font-semibold text-green-900 text-lg">Tanggal Selesai</label>
                        <input type="date" name="selesai"
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 p-4">
                    </div>
                </div>

                {{-- File Upload --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Upload CV / Persyaratan</label>
                    <input type="file" name="file_pendukung" required accept=".pdf,.doc,.docx"
                        class="mt-2 w-full text-sm bg-green-50 border border-green-300 rounded-2xl p-4">
                </div>

                {{-- BUTTON --}}
                <button
                    class="bg-gradient-to-r from-green-700 to-green-600 text-white px-8 py-4 rounded-2xl shadow-xl font-semibold w-full">
                    @if(isset($lowongan))
                        Lamar Lowongan
                    @else
                        Kirim Pendaftaran
                    @endif
                </button>

            </form>
        </div>
    </div>
</div>

@endsection
