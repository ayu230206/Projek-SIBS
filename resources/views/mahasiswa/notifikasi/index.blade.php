@extends('mahasiswa.layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        </div>

        {{-- Daftar Notifikasi --}}
        @forelse($notifikasi as $item)
            @php
                $title = $item->data['title'] ?? $item->data['judul'] ?? '';
                $message = $item->data['message'] ?? $item->data['pesan'] ?? '';

                // Cek apakah notifikasi tentang magang
                $isMagang = str_contains(strtolower($title), 'magang') 
                            || str_contains(strtolower($message), 'magang');

                // Jika magang → selalu arahkan ke halaman magang
                if ($isMagang) {
                    $link = route('mahasiswa.magang.index');
                }
                // Jika ada url (like postingan)
                elseif (!empty($item->data['url'])) {
                    $link = $item->data['url'];
                }
                // Jika ada link fallback
                elseif (!empty($item->data['link'])) {
                    $link = $item->data['link'];
                }
                // Jika benar-benar tanpa tujuan
                else {
                    $link = route('mahasiswa.dashboard');
                }
            @endphp

            <div class="bg-white shadow-sm rounded-xl p-5 mb-4 border border-gray-100 hover:shadow-md transition">
                <div class="flex items-start gap-4">

                    {{-- Icon --}}
                    <div class="bg-blue-50 text-blue-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 16h-1v-4h-1m1-4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                        </svg>
                    </div>

                    {{-- Isi --}}
                    <div class="flex-1">
                        {{-- Judul --}}
                        <h2 class="font-semibold text-gray-800 text-lg">
                            {{ $title ?: 'Tidak ada judul' }}
                        </h2>

                        {{-- Pesan --}}
                        <p class="text-gray-600 mt-1">
                            {{ $message ?: 'Tidak ada pesan' }}
                        </p>

                        {{-- Waktu --}}
                        <p class="text-gray-400 text-sm mt-2">
                            {{ $item->created_at->diffForHumans() }}
                        </p>

                        {{-- Tombol Detail --}}
                        <a href="{{ $link }}" class="mt-2 inline-block text-blue-600 hover:underline text-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

        @empty
            <div class="bg-white p-6 rounded-xl shadow-sm border text-center text-gray-600">
                Tidak ada notifikasi.
            </div>
        @endforelse
    </div>
</div>
@endsection
