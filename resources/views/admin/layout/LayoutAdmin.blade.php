@extends('admin.layout.app')

@section('body')

    {{-- 1. Navbar (Fixed Top) --}}
    {{-- Tinggi navbar diatur 90px di file navbar, jadi padding konten harus > 90px --}}
    @include('partials._navbar', ['userRole' => 'Admin'])

    {{-- 2. Sidebar (Fixed Left) --}}
    @include('admin.layout._sidebar')

    {{-- 3. Area Konten Utama --}}
    {{-- 
        PERBAIKAN DISINI:
        - padding-top: 120px (Memberi jarak aman agar judul tidak tertutup navbar)
        - margin-left: diurus oleh class 'content-shifted' untuk desktop
    --}}
    <main class="flex-grow-1 content-shifted konten-utama-bpdpks" style="padding-top: 90px; min-height: 100vh;">
        
        <div class="konten-sebenarnya container-fluid p-4">
            
            {{-- Flash Messages (Notifikasi Sukses/Gagal) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2 fs-4"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            {{-- Konten Halaman Dinamis --}}
            @yield('content')
            
        </div>
        
    </main>

    {{-- ================================================= --}}
    {{-- FLOATING WHATSAPP BUTTON (FITUR NO. 5)            --}}
    {{-- ================================================= --}}
    <a href="https://wa.me/6281234567890?text=Halo%20Tim%20Developer,%20saya%20butuh%20bantuan%20terkait%20Sistem%20Beasiswa%20Sawit." 
       target="_blank"
       title="Hubungi Developer via WhatsApp"
       style="
           position: fixed;
           bottom: 30px;       
           right: 30px;        
           width: 60px;        
           height: 60px;       
           background-color: #25d366; 
           color: white;       
           border-radius: 50%; 
           text-align: center;
           font-size: 35px;    
           box-shadow: 2px 2px 10px rgba(0,0,0,0.3); 
           z-index: 9999;      
           display: flex;
           align-items: center;
           justify-content: center;
           text-decoration: none;
           transition: all 0.3s ease;
       "
       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='4px 4px 15px rgba(0,0,0,0.4)';"
       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='2px 2px 10px rgba(0,0,0,0.3)';"
    >
        <i class="fab fa-whatsapp"></i>
    </a>

@endsection