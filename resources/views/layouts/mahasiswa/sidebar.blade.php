<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed md:static z-40 md:translate-x-0 w-64 bg-green-800 text-green-100 min-h-screen p-6 shadow-lg transition-transform duration-300">

    <nav class="flex flex-col gap-3">

        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded hover:bg-green-700">
            Dashboard
        </a>

        <a href="{{ route('mahasiswa.posts.index') }}" class="px-3 py-2 rounded hover:bg-green-700">
            Forum
        </a>

        <a href="{{ route('mahasiswa.profil.index') }}" class="px-3 py-2 rounded hover:bg-green-700">
            Profil
        </a>

        <a href="#" class="px-3 py-2 rounded hover:bg-green-700">
            Akademik
        </a>

        <a href="{{ route('mahasiswa.proyek.dashboard') }}" class="px-3 py-2 rounded hover:bg-green-700">
            Proyek Akhir
        </a>

        <a href="{{ route('mahasiswa.magang.dashboard') }}" class="px-3 py-2 rounded hover:bg-green-700">
            Magang
        </a>

        <a href="{{ route('mahasiswa.lowongankerja.index') }}" class="px-3 py-2 rounded hover:bg-green-700">
            Lowongan Kerja
        </a>
        <a href="#" class="px-3 py-2 rounded hover:bg-green-700">
            Notifikasi
        </a>

    </nav>
</aside>
