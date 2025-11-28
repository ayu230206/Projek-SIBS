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

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- ✅ HEADER --}}
    @include('layouts.mahasiswa.header')

    {{-- ✅ WRAPPER SIDEBAR + KONTEN --}}
    <div class="flex flex-1">

        {{-- ✅ SIDEBAR --}}
        @include('layouts.mahasiswa.sidebar')

        {{-- ✅ KONTEN UTAMA --}}
        <main class="flex-1 p-6 md:p-10">
            @yield('content')
        </main>

    </div>

    {{-- ✅ FOOTER (SELALU DI BAWAH) --}}
    @include('layouts.mahasiswa.footer')


    {{-- ✅ SCRIPT COPY LINK SHARE (WA, DLL) --}}
    <script>
        function copyLink(link) {
            navigator.clipboard.writeText(link).then(() => {
                alert("Link berhasil disalin!");
            }).catch(() => {
                alert("Gagal menyalin link");
            });
        }
    </script>

</body>
</html>
