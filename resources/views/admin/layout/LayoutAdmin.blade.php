@extends('admin.layout.app')

@section('body')

    {{-- 1. Navbar (Fixed Top) --}}
    @include('partials._navbar', ['userRole' => 'Admin'])

    {{-- 2. Sidebar (Fixed Left) --}}
    @include('admin.layout._sidebar')

    {{-- 3. Area Konten Utama --}}
    {{-- Padding top 100px agar tidak tertutup navbar --}}
    <main class="content-shifted" style="padding-top: 100px; min-height: 85vh; padding-bottom: 30px;">
        <div class="container-fluid px-4">
            
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            {{-- Isi Halaman --}}
            @yield('content')
            
        </div>
    </main>

    {{-- 4. Footer (Menggunakan Partial) --}}
    {{-- Dibungkus div 'content-shifted' agar footer bergeser ke kanan saat di desktop (tidak ketimpa sidebar) --}}
    <div class="content-shifted mt-auto">
        @include('partials._footer')
    </div>

    {{-- 5. Floating WhatsApp --}}
    <a href="https://wa.me/6281234567890" target="_blank"
       title="Hubungi Developer"
       style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background-color: #25d366; color: white; border-radius: 50%; text-align: center; font-size: 35px; box-shadow: 2px 2px 10px rgba(0,0,0,0.3); z-index: 9999; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.3s;">
        <i class="fab fa-whatsapp"></i>
    </a>

@endsection