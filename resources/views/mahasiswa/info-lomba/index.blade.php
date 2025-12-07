@extends('mahasiswa.layouts.app')

@section('title', 'Informasi Lomba')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">

        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            🎯 Informasi Lomba Terbaru
        </h1>

        @if($lombas->count() == 0)
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                Belum ada informasi lomba yang tersedia.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($lombas as $lomba)
                    <div class="bg-white rounded-lg shadow p-5 border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            {{ $lomba->judul }}
                        </h2>

                        <p class="text-sm text-gray-600 mb-2">
                            <b>Penyelenggara:</b> {{ $lomba->penyelenggara ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-600 mb-2">
                            <b>Deskripsi:</b><br>
                            {{ $lomba->deskripsi ?? '-' }}
                        </p>

                        <div class="text-sm text-gray-600 mb-2">
                            <b>Tanggal:</b>
                            {{ $lomba->tanggal_mulai ?? '-' }}
                            s/d
                            {{ $lomba->tanggal_berakhir ?? '-' }}
                        </div>

                        @if($lomba->link_pendaftaran)
                            <a href="{{ $lomba->link_pendaftaran }}"
                               target="_blank"
                               class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Daftar Sekarang
                            </a>
                        @else
                            <span class="inline-block mt-3 bg-gray-400 text-white px-4 py-2 rounded">
                                Info Internal Kampus
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
