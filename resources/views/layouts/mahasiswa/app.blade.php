<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Mahasiswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    @include('layouts.mahasiswa.css')
</head>
<body class="bg-gray-100">
    @include('layouts.mahasiswa.header')
    <div class="flex">
        @include('layouts.mahasiswa.sidebar')
        <main class="flex-1 p-6 md:p-10">
            @yield('content')
        </main>
    </div>
    @include('layouts.mahasiswa.footer')
</body>

</html>