{{-- File: resources/views/partials/_navbar.blade.php --}}

@php
    // 1. Tentukan path logo default
    $logoUrl = asset('img/logo-bpdpks-3_169.png');

    // 2. Cek apakah Admin sudah mengupload logo custom
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('settings/website_logo.png')) {
        $logoUrl = asset('storage/settings/website_logo.png');
    }
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
    <div class="container-fluid">
        {{-- Navbar brand will be hidden on mobile since we show the sidebar anyway, but kept for desktop --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            <img src="{{ $logoUrl }}?v={{ time() }}" 
                 alt="Logo SIBS" 
                 class="d-inline-block align-text-top me-3 bg-white rounded p-1 shadow-sm" 
                 style="height: 50px; width: auto; object-fit: contain;">
            
            <div class="d-flex flex-column">
                <span class="text-white fs-5 lh-1">SIBS</span>
                <span class="text-warning small lh-1" style="font-size: 0.75rem;">Beasiswa Sawit</span>
            </div>
        </a>

    {{-- Right side (Logout/User info) --}}
    <div class="d-flex align-items-center ms-auto">
        <span class="me-3 text-white-50 d-none d-md-inline">Halo, Admin</span>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf <!-- Wajib ada untuk rute POST Laravel! -->
        </form>
        <a href="#" class="btn btn-sm btn-outline-warning" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>
</div>


</nav>






