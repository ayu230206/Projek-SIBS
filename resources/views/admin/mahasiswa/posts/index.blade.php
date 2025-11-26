@extends('layouts.mahasiswa.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-900">Forum Mahasiswa</h1>

        <a href="{{ route('mahasiswa.posts.create') }}" 
           class="bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900">
            Buat Post Baru
        </a>
    </div>

    {{-- Daftar Post --}}
    <div class="space-y-6">

        @forelse ($posts as $post)

            <div class="bg-white p-5 rounded-xl shadow border border-green-200 hover:shadow-lg transition">

                {{-- Header Post --}}
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ $post->user->foto_profile 
                                ? asset('storage/'.$post->user->foto_profile) 
                                : asset('images/default-avatar.png') }}"
                         class="w-11 h-11 rounded-full object-cover border border-green-300">

                    <div>
                        <p class="font-semibold text-green-900 text-lg leading-tight">
                            {{ $post->user->nama_lengkap }}
                        </p>
                        <p class="text-sm text-green-600">
                            {{ $post->tanggal_post->format('d M Y · H:i') }}
                        </p>
                    </div>
                </div>

                {{-- Isi Post --}}
                @if($post->isi)
                    <p class="text-green-800 mb-4 leading-relaxed">{{ $post->isi }}</p>
                @endif

                {{-- Gambar Post --}}
                @if($post->gambar)
                    <div class="rounded-xl border border-green-200 bg-gray-50 p-3 flex justify-center mb-3">
                        <img src="{{ asset('storage/' . $post->gambar) }}"
                             class="max-w-full max-h-[600px] w-auto h-auto object-contain rounded-lg shadow-sm">
                    </div>
                @endif

                {{-- Footer --}}
                <div class="flex items-center gap-6 mt-4 text-sm text-green-700">

                    {{-- Komentar --}}
                    <a href="{{ route('mahasiswa.posts.show', $post->post_id) }}" 
                       class="flex items-center gap-1 hover:text-green-900">
                        💬 <span>{{ $post->comments->count() }} Komentar</span>
                    </a>

                    {{-- Like --}}
                    <button class="flex items-center gap-1 hover:text-green-900">
                        👍 <span>{{ $post->likes->count() }} Like</span>
                    </button>

                    {{-- Share --}}
                    <button class="flex items-center gap-1 hover:text-green-900">
                        🔗 <span>Share</span>
                    </button>

                </div>

            </div>

        @empty
            <p class="text-green-900">Belum ada post di forum.</p>
        @endforelse

    </div>

</div>

@endsection
