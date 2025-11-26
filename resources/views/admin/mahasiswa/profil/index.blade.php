@extends('layouts.mahasiswa.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    {{-- Judul --}}
    <h1 class="text-3xl font-bold text-green-900 mb-6">Profil Saya</h1>

    {{-- Kartu Profil --}}
    <div class="bg-white p-6 rounded-xl shadow border border-green-200 mb-8">
        <div class="flex items-center gap-6">
            <img src="{{ $user->foto_profile ? asset('storage/'.$user->foto_profile) : asset('images/default-avatar.png') }}"
                 class="w-24 h-24 rounded-full object-cover border-2 border-green-700">

            <div>
                <h2 class="text-2xl font-semibold text-green-900">{{ $user->nama_lengkap }}</h2>
                <p class="text-green-700">{{ $user->email }}</p>
                <p class="mt-2 text-green-800">{{ $user->bio ?? 'Belum ada bio.' }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('mahasiswa.profil.edit') }}"
               class="inline-block bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900">
               Edit Profil
            </a>
        </div>
    </div>

    {{-- Riwayat Postingan --}}
    <h2 class="text-2xl font-bold text-green-900 mb-4">Riwayat Postingan Saya</h2>

    @if($posts->count() > 0)
        <div class="space-y-6">
            @foreach ($posts as $post)
                <div class="bg-white p-5 rounded-xl shadow border border-green-200">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-green-600 text-sm">
                            Dipost pada: {{ $post->tanggal_post->format('d M Y · H:i') }}
                        </p>
                    </div>

                    {{-- Isi --}}
                    <p class="text-green-900 mb-3">{{ $post->isi }}</p>

                    {{-- Gambar --}}
                    @if($post->gambar)
                        <div class="flex gap-3 overflow-x-auto">
                            <img src="{{ asset('storage/' . $post->gambar) }}"
                                 class="w-40 h-40 object-cover rounded border">
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div class="flex items-center gap-6 mt-4 text-sm text-green-700">
                        <span>💬 {{ $post->comments->count() }} Komentar</span>
                        <span>👍 {{ $post->likes->count() }} Like</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-green-700">Belum ada postingan.</p>
    @endif

</div>
@endsection
