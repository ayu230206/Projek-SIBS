{{-- File: resources/views/partials/_navbar.blade.php --}}

@php
    // 1. Tentukan path logo default (pastikan file ini ada di public/images/)
    $logoUrl = asset('img/logo-bpdpks-3_169.png'); // Gunakan logo default sawit kamu

    // 2. Cek apakah Admin sudah mengupload logo custom ke Storage
    // Disimpan via AdminDashboardController @updateLogo
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('settings/website_logo.png')) {
        $logoUrl = asset('storage/settings/website_logo.png');
    }
@endphp

<nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4" style="height: 90px; background-color: var(--palm-green); z-index: 1050;">
    <div class="container-fluid">
        
        {{-- BAGIAN LOGO DINAMIS --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            {{-- Logo Image dengan Cache Buster (?v=time) --}}
            <img src="{{ $logoUrl }}?v={{ time() }}" 
                 alt="Logo SIBS" 
                 class="d-inline-block align-text-top me-2 bg-white rounded p-1" 
                 style="height: 50px; width: auto; object-fit: contain;">
            
            <span class="d-none d-sm-block text-white">
                SIBS <span class="text-warning">Sawit</span>
            </span>
        </a>

        {{-- Toggler untuk Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu Kanan (Profil User) --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-center">
                
                {{-- Dropdown User --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="me-2 text-end d-none d-lg-block">
                            <div class="fw-bold small">{{ Auth::user()->nama_lengkap ?? 'User' }}</div>
                            <div class="text-white-50 small" style="font-size: 0.75rem;">
                                {{ ucfirst(Auth::user()->role ?? 'Guest') }}
                            </div>
                        </div>
                        <img src="{{ Auth::user()->foto_profile ? asset('storage/' . Auth::user()->foto_profile) : asset('images/default-avatar.png') }}" 
                             class="rounded-circle border border-white" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                        <li>
                            <div class="dropdown-header">Halo, {{ Auth::user()->nama_lengkap ?? 'User' }}</div>
                        </li>
                        
                        @if(Auth::user()->role == 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2 text-secondary"></i>Pengaturan Logo</a></li>
                        @endif
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>