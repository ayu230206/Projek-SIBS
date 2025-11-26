<header class="bg-green-900 text-white px-6 py-4 shadow-md flex justify-between items-center">
    <h1 class="text-2xl font-bold">Dashboard Mahasiswa</h1>
    <div class="flex items-center gap-4">
        <span class="hidden md:block">{{ Auth::user()->nama_lengkap ?? 'Mahasiswa' }}</span>
        <img src="{{ Auth::user()->foto_profile ? asset('storage/'.Auth::user()->foto_profile) : asset('images/default-avatar.png') }}"
             class="w-10 h-10 rounded-full border border-green-700 object-cover">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                onclick="return confirm('Yakin ingin logout?')"
                class="bg-red-600 px-3 py-1 rounded text-white hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>
</header>
