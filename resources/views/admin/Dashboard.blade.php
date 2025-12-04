@extends('admin.layout.LayoutAdmin')

@section('title', 'Dashboard')

@section('content')
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-sawit-utama">
            Selamat Datang, {{ $adminName }}
        </h1>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600 hidden sm:inline">Administrator Panel</span>
            <div class="w-10 h-10 bg-sawit-highlight rounded-full flex items-center justify-center text-sawit-utama font-bold">
                A
            </div>
        </div>
    </header>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-sawit-utama">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Total Penerima</div>
                <i class="fas fa-users w-8 h-8 text-sawit-utama fs-3"></i>
            </div>
            <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['total_mahasiswa'] }}</p>
            <p class="text-xs text-gray-400 mt-1">Total seluruh data</p>
        </div>

        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Mahasiswa Aktif</div>
                <i class="fas fa-user-check w-8 h-8 text-green-500 fs-3"></i>
            </div>
            <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['mahasiswa_aktif'] }}</p>
            <p class="text-xs text-gray-400 mt-1">Status aktif</p>
        </div>
        
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-sawit-highlight">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Dana Tersalurkan</div>
                <i class="fas fa-coins w-8 h-8 text-sawit-highlight fs-3"></i>
            </div>
            <p class="text-3xl font-bold text-sawit-utama mt-2">{{ $stats['dana_tersalurkan'] }}</p>
            <p class="text-xs text-gray-400 mt-1">YTD</p>
        </div>
        
        <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-500">Perlu Verifikasi</div>
                <i class="fas fa-exclamation-circle w-8 h-8 text-red-500 fs-3"></i>
            </div>
            <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['dokumen_perlu_verifikasi'] }}</p>
            <p class="text-xs text-gray-400 mt-1">Dokumen/Nilai Pending</p>
        </div>

    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card-stat p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold mb-4 text-sawit-utama">Tren Peningkatan Kualitas SDM</h2>
                <div class="h-64 bg-gray-100 flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300">
                    <span class="text-gray-500">Area Grafik (Chart.js)</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card-stat p-6 rounded-xl shadow-lg h-full">
                <h2 class="text-xl font-semibold mb-4 text-sawit-utama flex items-center">
                    <i class="fas fa-bell w-6 h-6 mr-2 text-red-500"></i>
                    Notifikasi Terbaru
                </h2>

                <ul class="space-y-4">
                    @foreach ($notifications as $notification)
                        <li class="border-b pb-3 last:border-b-0">
                            <a href="{{ $notification['link'] }}" class="block hover:bg-green-50 p-2 rounded-lg transition duration-150">
                                <p class="font-medium text-sm text-gray-800">{{ $notification['title'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $notification['time'] }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('admin.notifikasi.index') }}" class="mt-6 block text-center text-sm font-semibold text-sawit-utama hover:text-green-700">
                    Lihat Semua Notifikasi
                </a>
            </div>
        </div>
    </div>
@endsection