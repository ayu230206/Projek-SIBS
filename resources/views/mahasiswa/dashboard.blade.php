@extends('mahasiswa.layouts.app')

@section('content')
<div x-data="{ menu: 'dashboard' }" class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 p-4 md:p-6">

    <div x-show="menu==='dashboard'" x-transition class="space-y-8">

        <!-- Header Section -->
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mb-4">
                Dashboard Mahasiswa
            </h1>
            <p class="text-lg text-gray-600">Kelola proyek, magang, dan aktivitas Anda dengan mudah.</p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Welcome Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4">Selamat Datang</h2>
                </div>
                <p class="text-gray-600">Selamat datang di Dashboard Mahasiswa. Area ini siap untuk diisi dengan konten dan fitur baru Anda.</p>
            </div>

            <!-- IPK Terakhir Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4">IPK Terakhir</h2>
                </div>
                <p class="text-gray-600 mb-4">Pantau nilai Indeks Prestasi Kumulatif Anda.</p>
                <div class="text-3xl font-bold text-blue-600">-</div>
            </div>

            <!-- Status Pengajuan Magang Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4">Status Pengajuan Magang</h2>
                </div>
                <p class="text-gray-600 mb-4">Lihat status pengajuan magang Anda.</p>
                <div class="flex items-center">
                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">-</span>
                </div>
            </div>

            <!-- Penelitian Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4">Penelitian</h2>
                </div>
                <p class="text-gray-600 mb-4">Belum Ada Informasi penelitian Anda.</p>
            </div>

            <!-- Lomba Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4">Lomba</h2>
                </div>
                <p class="text-gray-600 mb-4">Belum Ada informasi Lomba</p>
            </div>

            <!-- Info Kolaborasi Card -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-teal-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4">Info Kolaborasi</h2>
                </div>
                <p class="text-gray-600 mb-4">-</p>
            
            </div>

        </div>

    </div>

</div>
@endsection