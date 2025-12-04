@extends('admin.layout.LayoutAdmin')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIBS Sawit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Pengaturan Font dan Warna Dasar Tailwind -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAF5; /* Hijau muda pucat */
        }
        .admin-sidebar {
            background-color: #054D3F; /* Hijau Sawit Tua */
        }
        .card-stat {
            background-color: #FFFFFF;
        }
        .text-sawit-utama {
            color: #0B795D; /* Hijau Sawit */
        }
        .bg-sawit-utama {
            background-color: #0B795D;
        }
        .bg-sawit-highlight {
            background-color: #FFC400; /* Kuning Buah Sawit */
        }
        .text-sawit-highlight {
            color: #FFC400; 
        }
    </style>
</head>

<body>
    <!-- Layout Sederhana: Sidebar Kiri dan Konten Utama Kanan -->
    <div class="flex min-h-screen">
        <!-- Sidebar (Dummy Navigation) -->
        <nav class="admin-sidebar w-64 p-6 shadow-xl hidden md:block">
            <div class="text-white text-2xl font-bold mb-8 border-b border-green-700 pb-4">
                SIBS ADMIN
            </div>
            <ul class="space-y-3">
                <li><a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded-lg bg-green-700 text-white font-semibold transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a></li>
                <li><a href="{{ route('admin.mahasiswa.data.index') }}" class="flex items-center p-2 rounded-lg text-green-200 hover:bg-green-700 transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2a3 3 0 015.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M10 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M10 18a5.002 5.002 0 004 0m-4-2H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v8a2 2 0 01-2 2h-6"></path></svg>
                    Data Mahasiswa
                </a></li>
                <li><a href="{{ route('admin.mahasiswa.dokumen.index') }}" class="flex items-center p-2 rounded-lg text-green-200 hover:bg-green-700 transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Verifikasi Dokumen
                </a></li>
                <li><a href="{{ route('admin.keuangan.index') }}" class="flex items-center p-2 rounded-lg text-green-200 hover:bg-green-700 transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8a4 4 0 00-4 4v2a4 4 0 004 4m0-12v12"></path></svg>
                    Keuangan & Beasiswa
                </a></li>
                </a></li>
                <li><a href="{{ route('admin.keuangan.index') }}" class="flex items-center p-2 rounded-lg text-green-200 hover:bg-green-700 transition duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8a4 4 0 00-4 4v2a4 4 0 004 4m0-12v12"></path></svg>
                    Keuangan & Beasiswa
                </a></li>
                <!-- Tambahkan lebih banyak link navigasi di sini -->
            </ul>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-1 p-6 md:p-10 lg:pl-0 lg:ml-10 mt-10">
            <!-- Header Konten -->
            <header class="mb-8 flex justify-between items-center">
                <h1 class="text-3xl font-extrabold text-sawit-utama">
                    Selamat Datang, {{ $adminName }}
                </h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden sm:inline">Administrator Panel</span>
                    <!-- Icon Admin -->
                    <div class="w-10 h-10 bg-sawit-highlight rounded-full flex items-center justify-center text-sawit-utama font-bold">
                        A
                    </div>
                </div>
            </header>

            <!-- Bagian 1: Kartu Statistik (Ringkasan Data Sawit) -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <!-- Kartu 1: Total Mahasiswa -->
                <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-sawit-utama hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-medium text-gray-500">Total Penerima Beasiswa</div>
                        <svg class="w-8 h-8 text-sawit-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2a3 3 0 015.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M10 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M10 18a5.002 5.002 0 004 0m-4-2H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v8a2 2 0 01-2 2h-6"></path></svg>
                    </div>
                    <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['total_mahasiswa'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total seluruh data mahasiswa</p>
                </div>

                <!-- Kartu 2: Mahasiswa Aktif -->
                <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-green-500 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-medium text-gray-500">Mahasiswa Aktif Saat Ini</div>
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-7.618 4.016M2.944 12a11.955 11.955 0 014.016-7.618M12 21.056a11.955 11.955 0 01-4.016-7.618m0 0L3 12m18 0l-4.016-7.618m-7.618-4.016a11.955 11.955 0 017.618 4.016M21.056 12a11.955 11.955 0 01-4.016 7.618m0 0L21 12"></path></svg>
                    </div>
                    <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['mahasiswa_aktif'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Status aktif registrasi ulang</p>
                </div>
                
                <!-- Kartu 3: Dana Tersalurkan -->
                <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-sawit-highlight hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-medium text-gray-500">Total Dana Tersalurkan (YTD)</div>
                        <svg class="w-8 h-8 text-sawit-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8a4 4 0 00-4 4v2a4 4 0 004 4m0-12v12"></path></svg>
                    </div>
                    <p class="text-3xl font-bold text-sawit-utama mt-2">{{ $stats['dana_tersalurkan'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Sejak awal tahun anggaran</p>
                </div>
                
                <!-- Kartu 4: Perlu Verifikasi -->
                <div class="card-stat p-6 rounded-xl shadow-lg border-l-4 border-red-500 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-medium text-gray-500">Dokumen Perlu Verifikasi</div>
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-4xl font-bold text-sawit-utama mt-2">{{ $stats['dokumen_perlu_verifikasi'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">MoU, Nilai, atau Registrasi Ulang</p>
                </div>

            </section>

            <!-- Bagian 2: Aktivitas & Statistik Detail -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Kiri (2/3): Grafik Placeholder & Detail Lainnya -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Grafik Placeholder -->
                    <div class="card-stat p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-sawit-utama">Tren Peningkatan Kualitas SDM</h2>
                        <div class="h-64 bg-gray-100 flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300">
                            <span class="text-gray-500">Area Grafik: Distribusi IPK Mahasiswa per Tahun (Placeholder Chart.js)</span>
                        </div>
                    </div>
                    
                    <!-- Detail Kerjasama & Lowongan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="card-stat p-6 rounded-xl shadow-lg border-t-4 border-green-500">
                            <h3 class="text-lg font-semibold text-sawit-utama mb-2">Kerjasama Kampus</h3>
                            <p class="text-4xl font-bold text-green-500">{{ $stats['kampus_kerjasama'] }}</p>
                            <p class="text-sm text-gray-500">Total Kampus Mitra MoU</p>
                            <a href="{{ route('admin.kampus.index') }}" class="mt-3 block text-sm text-sawit-utama hover:underline">Kelola Kerjasama →</a>
                        </div>
                        <div class="card-stat p-6 rounded-xl shadow-lg border-t-4 border-sawit-highlight">
                            <h3 class="text-lg font-semibold text-sawit-utama mb-2">Lowongan Magang</h3>
                            <p class="text-4xl font-bold text-sawit-highlight">{{ $stats['lowongan_magang_aktif'] }}</p>
                            <p class="text-sm text-gray-500">Lowongan yang sedang dibuka</p>
                            <a href="{{ route('admin.lowongan.index') }}" class="mt-3 block text-sm text-sawit-utama hover:underline">Kelola Lowongan →</a>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan (1/3): Notifikasi Aktivitas -->
                <div class="lg:col-span-1">
                    <div class="card-stat p-6 rounded-xl shadow-lg h-full">
                        <h2 class="text-xl font-semibold mb-4 text-sawit-utama flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                            Notifikasi & Tugas Mendesak
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

        </main>
    </div>
</body>

</html>