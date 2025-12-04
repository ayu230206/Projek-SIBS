<!DOCTYPE html>

<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Dashboard') | Beasiswa Sawit</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome (Icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
:root {
--palm-green: #054D3F; /* Hijau Sawit Tua /
--palm-gold: #FFC400; / Kuning Buah Sawit /
--sidebar-width: 260px;
}
body {
background-color: #F8FAF5; / Hijau muda pucat /
font-family: 'Inter', sans-serif;
}
.sidebar {
width: var(--sidebar-width);
height: 100vh;
position: fixed;
top: 0;
left: 0;
background-color: var(--palm-green);
color: #ffffff;
padding: 15px;
overflow-y: auto;
z-index: 1030;
box-shadow: 0 0 10px rgba(0,0,0,0.2);
}
.sidebar-header {
padding-bottom: 15px;
margin-bottom: 20px;
border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}
.sidebar-menu-link {
display: flex;
align-items: center;
padding: 10px 15px;
color: rgba(255, 255, 255, 0.8);
text-decoration: none;
border-radius: 5px;
margin-bottom: 5px;
transition: background-color 0.2s, color 0.2s;
}
.sidebar-menu-link:hover {
background-color: rgba(255, 255, 255, 0.1);
color: #ffffff;
}
.sidebar-menu-link.active {
background-color: #0B795D; / Hijau sedikit lebih terang /
color: #ffffff;
font-weight: bold;
}
.sidebar-menu-link i {
margin-right: 10px;
}
.content-wrapper {
margin-left: var(--sidebar-width);
padding-top: 60px; / Space for fixed navbar */
min-height: 100vh;
}
.hero-section {
border-bottom: 3px solid var(--palm-gold);
padding: 15px 0;
margin-bottom: 25px !important;
}
.card-stat {
border-radius: 0.75rem;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
transition: transform 0.2s;
}
.card-stat:hover {
transform: translateY(-2px);
}
.navbar {
background-color: var(--palm-green) !important;
box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.footer {
background-color: var(--palm-green) !important;
}
@media (max-width: 991px) {
.sidebar {
left: calc(-1 * var(--sidebar-width));
transition: left 0.3s;
}
.sidebar.active {
left: 0;
}
.content-wrapper {
margin-left: 0;
padding-top: 60px;
}
}
</style>
@yield('styles')
</head>
<body>
@yield('body')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Simple script to handle responsive sidebar toggle
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.navbar-toggler');
        const sidebar = document.querySelector('.sidebar');
        if (toggle && sidebar) {
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }
    });
</script>
@yield('scripts')


</body>
</html>