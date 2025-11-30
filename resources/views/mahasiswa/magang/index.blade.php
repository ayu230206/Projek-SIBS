@extends('mahasiswa.layouts.app')
@section('title', 'Pengajuan Magang')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 max-w-6xl mx-auto py-8">
    

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-2xl text-center shadow-xl animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD FORM PENDAFTARAN --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-green-200 mb-12 overflow-hidden hover:shadow-3xl transition-shadow duration-300">

        <div class="px-8 py-6 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-xl flex items-center gap-3">
            <span class="text-3xl">📝</span> Pendaftaran Magang
        </div>

        <div class="p-8">

            <form action="{{ route('mahasiswa.magang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

                @csrf

                {{-- Input Tempat --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Tempat Magang</label>
                    <input type="text" name="tempat_magang"
                        class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 focus:ring-4 focus:ring-green-400 focus:bg-white p-4 transition-all duration-300 shadow-sm"
                        required>
                </div>

                {{-- Posisi --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Posisi / Jabatan</label>
                    <input type="text" name="posisi"
                        class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 focus:ring-4 focus:ring-green-400 focus:bg-white p-4 transition-all duration-300 shadow-sm"
                        required>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 focus:ring-4 focus:ring-green-400 focus:bg-white p-4 min-h-[120px] transition-all duration-300 shadow-sm resize-none"></textarea>
                </div>

                {{-- Tanggal --}}
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Tanggal Mulai</label>
                        <input type="date" name="mulai"
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 focus:ring-4 focus:ring-green-400 focus:bg-white p-4 transition-all duration-300 shadow-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-green-900 text-lg">Tanggal Selesai</label>
                        <input type="date" name="selesai"
                            class="mt-2 w-full rounded-2xl border border-green-300 bg-green-50 focus:ring-4 focus:ring-green-400 focus:bg-white p-4 transition-all duration-300 shadow-sm">
                    </div>
                </div>

                {{-- Upload File --}}
                <div>
                    <label class="font-semibold text-green-900 text-lg">Upload CV / Persyaratan</label>
                    <input type="file" name="file_pendukung" accept=".pdf,.doc,.docx"
                        class="mt-2 w-full text-sm text-green-800 bg-green-50 border border-green-300 rounded-2xl p-4 cursor-pointer hover:bg-green-100 transition-all duration-300 shadow-sm">
                </div>

                {{-- Button --}}
                <button
                    class="bg-gradient-to-r from-green-700 to-green-600 hover:from-green-800 hover:to-green-700 text-white px-8 py-4 rounded-2xl shadow-xl font-semibold transition-all duration-300 w-full md:w-auto hover:shadow-2xl transform hover:scale-105">
                    Kirim Pendaftaran
                </button>

            </form>
        </div>
    </div>

    {{-- CARD RIWAYAT --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-green-200 overflow-hidden hover:shadow-3xl transition-shadow duration-300">

        <div class="px-8 py-6 bg-gradient-to-r from-green-700 to-green-600 text-white font-bold text-xl flex items-center gap-3">
            <span class="text-3xl">📋</span> Riwayat Pendaftaran Magang
        </div>

        <div class="p-8 overflow-x-auto">

            <table class="w-full text-sm text-center rounded-2xl overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-green-700 to-green-600 text-white text-sm">
                        <th class="p-4">#</th>
                        <th class="p-4">Tempat</th>
                        <th class="p-4">Posisi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">File</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @forelse ($magangs as $item)
                        <tr class="border-b border-gray-200 hover:bg-green-50 transition-all duration-300">

                            <td class="p-4 font-medium">{{ $loop->iteration }}</td>

                            <td class="p-4 font-semibold text-green-900">{{ $item->tempat_magang }}</td>

                            <td class="p-4">{{ $item->posisi }}</td>

                            {{-- STATUS --}}
                            <td class="p-4">
                                @if($item->status_pengajuan == 'pending')
                                    <span class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-4 py-2 rounded-full shadow-md text-xs font-semibold animate-pulse">
                                        Pending
                                    </span>
                                @elseif($item->status_pengajuan == 'approved')
                                    <span class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-full shadow-md text-xs font-semibold">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-full shadow-md text-xs font-semibold">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">{{ $item->tanggal_pengajuan }}</td>

                            <td class="p-4">
                                @if($item->file_pendukung)
                                    <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank"
                                       class="text-blue-600 hover:text-blue-800 hover:underline font-semibold transition-colors duration-300">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-gray-500 italic text-center bg-gray-50 rounded-b-2xl">Belum ada pengajuan magang.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection