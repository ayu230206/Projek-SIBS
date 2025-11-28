@extends('layouts.mahasiswa.app')
@section('title', 'Pengajuan Magang')

@section('content')

<div class="max-w-6xl mx-auto py-8">

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-green-600 text-white p-4 rounded-xl text-center shadow-lg animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD FORM PENDAFTARAN --}}
    <div class="bg-white rounded-3xl shadow-xl border border-green-200 mb-12 overflow-hidden">

        <div class="px-8 py-5 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-lg flex items-center gap-2">
            <span class="text-2xl">📝</span> Pendaftaran Magang
        </div>

        <div class="p-8">

            <form action="{{ route('mahasiswa.magang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">

                @csrf

                {{-- Input Tempat --}}
                <div>
                    <label class="font-semibold text-green-900">Tempat Magang</label>
                    <input type="text" name="tempat_magang"
                        class="mt-1 w-full rounded-xl border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-600 focus:bg-white p-3 transition"
                        required>
                </div>

                {{-- Posisi --}}
                <div>
                    <label class="font-semibold text-green-900">Posisi / Jabatan</label>
                    <input type="text" name="posisi"
                        class="mt-1 w-full rounded-xl border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-600 focus:bg-white p-3 transition"
                        required>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="font-semibold text-green-900">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="mt-1 w-full rounded-xl border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-600 focus:bg-white p-3 min-h-[100px] transition"></textarea>
                </div>

                {{-- Tanggal --}}
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="font-semibold text-green-900">Tanggal Mulai</label>
                        <input type="date" name="mulai"
                            class="mt-1 w-full rounded-xl border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-600 focus:bg-white p-3">
                    </div>
                    <div>
                        <label class="font-semibold text-green-900">Tanggal Selesai</label>
                        <input type="date" name="selesai"
                            class="mt-1 w-full rounded-xl border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-600 focus:bg-white p-3">
                    </div>
                </div>

                {{-- Upload File --}}
                <div>
                    <label class="font-semibold text-green-900">Upload CV / Persyaratan</label>
                    <input type="file" name="file_pendukung" accept=".pdf,.doc,.docx"
                        class="mt-2 w-full text-sm text-green-800 bg-green-50 border border-green-300 rounded-xl p-3 cursor-pointer">
                </div>

                {{-- Button --}}
                <button
                    class="bg-green-700 hover:bg-green-900 text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition w-full md:w-auto">
                    Kirim Pendaftaran
                </button>

            </form>
        </div>
    </div>

    {{-- CARD RIWAYAT --}}
    <div class="bg-white rounded-3xl shadow-xl border border-green-200 overflow-hidden">

        <div class="px-8 py-5 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-lg flex items-center gap-2">
            <span class="text-2xl">📋</span> Riwayat Pendaftaran Magang
        </div>

        <div class="p-8 overflow-x-auto">

            <table class="w-full text-sm text-center">
                <thead>
                    <tr class="bg-green-700 text-white text-sm">
                        <th class="p-3">#</th>
                        <th class="p-3">Tempat</th>
                        <th class="p-3">Posisi</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">File</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @forelse ($magangs as $item)
                        <tr class="border-b hover:bg-green-50 transition">

                            <td class="p-4">{{ $loop->iteration }}</td>

                            <td class="p-4 font-semibold text-green-900">{{ $item->tempat_magang }}</td>

                            <td class="p-4">{{ $item->posisi }}</td>

                            {{-- STATUS --}}
                            <td class="p-4">
                                @if($item->status_pengajuan == 'pending')
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-xl shadow text-xs font-semibold">
                                        Pending
                                    </span>
                                @elseif($item->status_pengajuan == 'approved')
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-xl shadow text-xs font-semibold">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="bg-red-600 text-white px-3 py-1 rounded-xl shadow text-xs font-semibold">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">{{ $item->tanggal_pengajuan }}</td>

                            <td class="p-4">
                                @if($item->file_pendukung)
                                    <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank"
                                       class="text-blue-600 hover:underline font-semibold">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-gray-500 italic">Belum ada pengajuan magang.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
