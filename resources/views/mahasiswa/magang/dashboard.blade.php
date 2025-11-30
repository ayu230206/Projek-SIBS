@extends('mahasiswa.layouts.app')
@section('title', 'Dashboard Magang')

@section('content')

<div class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen py-10 px-4">
    

    <div class="max-w-3xl mx-auto">

        <!-- Title -->
        <h1 class="text-4xl font-extrabold text-green-900 text-center mb-4">
            Dashboard Magang
        </h1>

        <p class="text-center text-green-700 text-lg mb-12">
            Kelola seluruh kebutuhan magang Anda melalui menu berikut.
        </p>

        <!-- Cards Vertical -->
        <div class="flex flex-col gap-6">

            <!-- Portal Magang -->
            <a href="{{ route('mahasiswa.magang.index') }}"
               class="group bg-white rounded-2xl p-8 shadow-lg border border-blue-200 hover:shadow-xl hover:border-blue-400 transition">

                <div class="flex items-start gap-5">
                    <div class="bg-blue-600 text-white p-4 rounded-xl text-2xl group-hover:bg-blue-700 transition">
                        📄
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold text-blue-900 mb-2">
                            Portal Magang
                        </h2>
                        <p class="text-blue-700 leading-relaxed">
                            Ajukan magang dan kelola seluruh riwayat pengajuan Anda.
                        </p>
                    </div>
                </div>
            </a>

            <!-- Lowongan Magang -->
            <a href="{{ route('mahasiswa.magang.lowongan') }}"
               class="group bg-white rounded-2xl p-8 shadow-lg border border-yellow-200 hover:shadow-xl hover:border-yellow-400 transition">

                <div class="flex items-start gap-5">
                    <div class="bg-yellow-600 text-white p-4 rounded-xl text-2xl group-hover:bg-yellow-700 transition">
                        💼
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold text-yellow-900 mb-2">
                            Lowongan Magang
                        </h2>
                        <p class="text-yellow-700 leading-relaxed">
                            Temukan lowongan magang terbaru yang bisa Anda lamar sesuai minat dan keahlian.
                        </p>
                    </div>
                </div>
            </a>

        </div>

    </div>

</div>

@endsection
