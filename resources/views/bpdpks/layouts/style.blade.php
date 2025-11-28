<style>
/* ========================================================= */
/* 1. VARIABEL & GLOBAL STYLES */
/* ========================================================= */
:root {
    --primary: #0b3a2e; /* Hijau Tua/Moss Green (Warna Dominan) */
    --accent: #bfa15a; /* Emas Kusam/Ochre (Warna Aksen) */
    --accent-light: #d8c491; /* Aksen Lebih Terang (Untuk teks/hover) */
    --text-color: #35423f; /* Teks Hitam Kehijauan */
    --background-light: #f4f7f6; /* Background Sangat Terang */
    --card-background: #ffffff; /* Background Kartu */
    --sidebar-width: 250px; /* Lebar Sidebar yang Konsisten */
}

/* Global Reset & Body: PENTING agar sidebar dan content-wrapper berdampingan */
body {
    background-color: var(--background-light);
    color: var(--text-color);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    
    /* FIX LAYOUT: Body sebagai flex container horizontal untuk Sidebar dan Content-Wrapper */
    display: flex;
    min-height: 100vh;
}

/* ========================================================= */
/* 2. SIDEBAR STYLES (Tidak ada perubahan) */
/* ========================================================= */
.sidebar {
    height: 100vh;
    width: var(--sidebar-width);
    position: fixed;
    top: 0;
    left: 0;
    background-color: var(--primary); 
    color: #fff;
    padding: 20px 15px;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.sidebar-header {
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 20px;
}

.sidebar-header h4 {
    color: var(--accent-light); 
    font-weight: 700;
    margin-bottom: 0;
    font-size: 1.3rem;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    flex-grow: 1;
}

.sidebar-menu-item {
    margin-bottom: 8px;
}

.sidebar-menu-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.2s, color 0.2s;
    font-size: 0.95rem;
}

.sidebar-menu-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.sidebar-menu-link.active {
    background-color: var(--accent); 
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.sidebar-menu-link i {
    margin-right: 12px;
    font-size: 1.1rem;
    min-width: 20px;
    text-align: center;
}

.sidebar-footer {
    padding-top: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.sidebar-footer .user-info {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.85rem;
}

.sidebar-footer a {
    color: var(--accent-light);
    text-decoration: none;
    margin-left: 5px;
}


/* ========================================================= */
/* 3. MAIN CONTENT & FOOTER STYLES (PERBAIKAN FOOTER) */
/* ========================================================= */

/* FIX: Wrapper Utama untuk konten sebelah kanan sidebar */
.content-wrapper { 
    margin-left: var(--sidebar-width); /* Offset dari sidebar */
    flex-grow: 1; /* Mengisi sisa lebar horizontal */
    display: flex; /* Jadikan flex container */
    flex-direction: column; /* Mengatur item (main & footer) secara vertikal */
    min-height: 100vh;
}

/* FIX: Main Content */
main {
    /* Hapus margin-left */
    padding: 30px;
    flex-grow: 1; /* PENTING: Mendorong footer ke bagian bawah */
}

/* Hapus CSS ini karena sudah diganti oleh .content-wrapper */
/* .footer-wrapper { 
    margin-left: var(--sidebar-width);
    width: calc(100% - var(--sidebar-width));
} */

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.welcome {
    font-size: 1.8rem;
    font-weight: 300;
    color: var(--text-color);
}

.subtle {
    color: #8c9fa8;
    font-size: 0.95rem;
}

.controls div {
    font-size: 0.9rem;
    color: #6c757d;
}

/* ========================================================= */
/* 4. COMPONENT STYLES (Tidak ada perubahan) */
/* ========================================================= */
.card-custom {
    background-color: var(--card-background);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s;
    border: 1px solid #e5e5e5;
}

.section-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 10px;
}

.badge {
    padding: 0.4em 0.8em;
    font-weight: 600;
    border-radius: 0.5rem;
    font-size: 0.85em;
    min-width: 80px; 
    text-align: center;
    line-height: 1.2;
}

.badge-approved { background-color: #d4edda; color: #155724; }
.badge-review { background-color: #fff3cd; color: #856404; }
.badge-pending { background-color: #cfe2ff; color: #0d6efd; }
.badge-rejected { background-color: #f8d7da; color: #721c24; }
.badge-danger { background-color: #e07a5f; color: #fff; }

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.1em 0.5em;
    border-radius: 5px;
    margin: 0 2px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: var(--primary) !important;
    color: #fff !important;
    border: none;
}

table.dataTable thead th {
    background-color: rgba(11, 58, 46, 0.05);
    color: var(--primary);
    font-weight: 600;
    border-bottom: 2px solid var(--primary);
}

.form-select, .form-control {
    border-radius: 8px;
    font-size: 0.9rem;
    border-color: #e0e0e0;
}

.chart-box {
    padding: 10px 0;
    margin-bottom: 10px;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.text-success { color: var(--primary) !important; }
.bg-success-subtle { background-color: rgba(11, 58, 46, 0.1) !important; }
.text-warning { color: #e07a5f !important; }
.bg-warning-subtle { background-color: rgba(224, 122, 95, 0.1) !important; }
</style>