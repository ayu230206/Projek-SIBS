@extends('layouts.mahasiswa.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    {{-- Judul --}}
    <h1 class="text-3xl font-bold text-green-900 mb-6">Profil Saya</h1>

    {{-- Kartu Profil --}}
    <div class="bg-white p-6 rounded-2xl shadow-md border border-green-200 mb-8">
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
                <div class="bg-white p-6 rounded-2xl shadow-md border border-green-200 relative">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-green-600 text-sm">
                            Dipost pada: {{ $post->tanggal_post->format('d M Y · H:i') }}
                        </p>

                        {{-- ✅ TITIK 3 MENU --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="text-xl px-2 hover:text-green-900">
                                ⋮
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg overflow-hidden z-20">

                                <form action="{{ route('mahasiswa.posts.destroy', $post->post_id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">
                                         Hapus 
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- Isi --}}
                    <p class="text-green-900 mb-3 whitespace-pre-line">
                        {{ $post->isi }}
                    </p>

                    {{-- Gambar Ditengah & Responsif --}}
                    @if($post->gambar)
                        <div class="flex justify-center mt-4">
                            <img src="{{ asset('storage/' . $post->gambar) }}"
                                 class="max-w-full md:max-w-2xl h-auto rounded-xl border shadow-sm">
                        </div>
                    @endif

                    {{-- ✅ Footer: Komentar, Like, Share --}}
                    <div class="flex items-center gap-6 mt-4 text-sm text-green-700">
                        <span>💬 {{ $post->comments->count() }} Komentar</span>
                        <span>👍 {{ $post->likes->count() }} Like</span>

                        {{-- ✅ Tombol Share --}}
                        <a href="#"
                           onclick="navigator.share({
                               title: 'Postingan Mahasiswa',
                               text: '{{ \Illuminate\Support\Str::limit($post->isi, 50) }}',
                               url: '{{ url()->current() }}'
                           })"
                           class="flex items-center gap-1 hover:text-green-900">
                            🔗 Share
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <p class="text-green-700">Belum ada postingan.</p>
    @endif

</div>
@endsection
