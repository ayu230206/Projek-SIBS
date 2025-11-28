<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="fas fa-seedling me-2"></i>BPDPKS Admin</h4>
        <small style="color: rgba(255, 255, 255, 0.6);">Sistem Monitoring Beasiswa</small>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a href="{{ route('bpdpks.dashboard') }}" class="sidebar-menu-link active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
      <li class="sidebar-menu-item">
    <a href="{{ route('bpdpks.keuangan.index') }}" class="sidebar-menu-link">
        <i class="fas fa-wallet"></i> Informasi Keuangan
    </a>
</li>
        <li class="sidebar-menu-item">
            <a href="#kampus" class="sidebar-menu-link">
                <i class="fas fa-university"></i> Kampus & Kerjasama
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="#lowongan" class="sidebar-menu-link">
                <i class="fas fa-bullhorn"></i> Lowongan Kerja (CRUD)
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="#data-mahasiswa" class="sidebar-menu-link">
                <i class="fas fa-user-graduate"></i> Data Mahasiswa (OLAP)
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="#persetujuan" class="sidebar-menu-link">
                <i class="fas fa-check-circle"></i> Persetujuan (Magang/Kampus)
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="#feedback" class="sidebar-menu-link">
                <i class="fas fa-comment-dots"></i> Feedback Mahasiswa
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="user-info">
            Logged in as: <br>
            <strong>{{ Session::get('username') ?? 'BPDPKS User' }}</strong>
            
            {{-- FIX LOGOUT: Menggunakan JavaScript untuk memicu POST Form --}}
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('bpdpks-logout-form').submit();">
               Logout
            </a>
        </div>
    </div>
</div>

{{-- Formulir POST Logout Tersembunyi (Bisa diletakkan di sini atau di layout utama) --}}
<form id="bpdpks-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf 
</form>