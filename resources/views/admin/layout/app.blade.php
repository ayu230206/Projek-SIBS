<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Beasiswa Sawit</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
    /* Mengimport Font Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background-color: #F8FAF5;
    }

    /* --- Custom CSS untuk Admin Sawit --- */
    :root {
        --palm-green: #054D3F;
        --palm-gold: #FFC400;
        --sidebar-width: 260px;
    }

    /* 1. Sidebar Styling (Fixed Position) */
    .admin-sidebar {
        background-color: var(--palm-green);
        min-height: 100vh;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        overflow-y: auto;
        z-index: 100;
    }

    /* 2. FIX LAYOUT: Margin Content agar tidak tertutup Sidebar */
    /* Default (HP): Margin 0 */
    .content-shifted {
        margin-left: 0;
        transition: margin-left 0.3s;
    }

    /* Laptop/PC (Layar > 768px): Geser ke kanan 260px */
    @media (min-width: 768px) {
        .content-shifted {
            margin-left: var(--sidebar-width); /* 260px */
        }
    }
    
    /* 3. Navbar Styling */
    .navbar {
        background-color: var(--palm-green) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 101; /* Di atas sidebar */
    }

    /* 4. Active Menu State */
    .sidebar-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 0.375rem;
        font-weight: bold;
        color: #FFC400 !important;
    }

    /* Gaya Lainnya */
    .text-sawit-utama { color: #0B795D; }
    .bg-sawit-utama { background-color: #0B795D; }
    .bg-sawit-highlight { background-color: #FFC400; }
    .text-sawit-highlight { color: #FFC400; }
    .card-stat {
        background-color: #FFFFFF;
        border-radius: 0.75rem;
        transition: transform 0.2s;
    }
    .card-stat:hover {
        transform: translateY(-2px);
    }

    .konten-utama-bpdpks {
        background-image: url('{{ asset('img/sawit2.jpg') }} ');
        background-size: cover; /* Agar gambar mencakup seluruh area */
        background-position: center center; /* Menjaga gambar di tengah */
        background-repeat: no-repeat; /* Mencegah pengulangan gambar */
        /* Anda mungkin perlu menambahkan tinggi minimum atau padding di sini */
        min-height: 100vh; 
        color: white; /* Contoh: Mengatur warna teks agar kontras dengan latar belakang */
    }
    
    /* Tambahkan lapisan gelap (overlay) untuk meningkatkan keterbacaan teks */
    .konten-utama-bpdpks::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.4); /* Overlay hitam 40% */
        z-index: 1; /* Pastikan overlay di bawah teks */
    }

    /* Pastikan konten Anda memiliki z-index yang lebih tinggi dari overlay */
    .konten-sebenarnya {
        position: relative;
        z-index: 2;
    }

</style>
    @yield('styles')
</head>
<body>

    @yield('body')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>