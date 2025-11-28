<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>BPDPKS — @yield('title', 'Dashboard')</title>

    {{-- CSS & Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJdf8wP1J+9WkL3U7PzJt3/t8k3w7z9V8h9/D6A/uJ0FfI/5p4pQ5eP/S4T4Gg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Include Style (Mengandung CSS kustom Anda) --}}
    @include('bpdpks.layouts.style') 
</head>
<body>

    {{-- 1. Sidebar Fixed --}}
    @include('bpdpks.layouts.sidebar')

    {{-- 2. Content Wrapper (Menggantikan Main & Footer Wrapper sebelumnya) --}}
    <div class="content-wrapper"> 
        
        <main>
            {{-- Slot untuk konten Dashboard/Halaman lain --}}
            @yield('content')
        </main>
        
        {{-- Footer diletakkan di dalam content-wrapper --}}
        @include('bpdpks.layouts.footer') 

    </div>

    {{-- JQuery dan JS Libraries --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

</body>
</html>