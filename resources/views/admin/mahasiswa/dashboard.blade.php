@extends('layouts.mahasiswa.app')
@section('content')

<div x-data="{ menu: 'dashboard' }" class="p-4 md:p-6">

    <div x-show="menu==='dashboard'" x-transition>

        <h1 class="text-3xl md:text-4xl font-extrabold text-green-900 mb-8">
            Dashboard Mahasiswa
        </h1>

        <div class="bg-white p-10 rounded-2xl shadow-lg border border-gray-100">
            <p class="text-xl text-gray-700">Selamat datang di Dashboard Mahasiswa.</p>
            <p class="text-gray-500 mt-2">Area ini siap untuk diisi dengan konten dan fitur baru Anda.</p>
        </div>
        
    </div>

</div>

@endsection