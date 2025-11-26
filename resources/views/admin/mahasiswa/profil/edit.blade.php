{{-- resources/views/admin/mahasiswa/profil/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-green-100 min-h-screen flex">

    <main class="flex-1 p-8 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-green-900 mb-6">Edit Profil</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-900 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Foto Profil --}}
            <div class="mb-6" x-data="{ fotoPreview: '{{ $user->foto_profile ? asset("storage/".$user->foto_profile) : asset("images/default-avatar.png") }}' }">
                <label class="block text-green-800 mb-2 font-semibold">Foto Profil</label>
                <img :src="fotoPreview" class="w-24 h-24 rounded-full mb-2 object-cover border-2 border-green-700">
                <input type="file" name="foto_profile" @change="fotoPreview = URL.createObjectURL($event.target.files[0])" class="block">
            </div>

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="block text-green-800 mb-1 font-semibold">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="border p-2 rounded w-full">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-green-800 mb-1 font-semibold">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="border p-2 rounded w-full">
            </div>

            {{-- Bio --}}
            <div class="mb-6">
                <label class="block text-green-800 mb-1 font-semibold">Bio</label>
                <textarea name="bio" class="border p-2 rounded w-full">{{ $user->bio }}</textarea>
            </div>

            <button type="submit" class="bg-green-800 text-white px-6 py-2 rounded hover:bg-green-900">Update Profil</button>
        </form>

        <a href="{{ route('dashboard') }}" class="inline-block mt-6 text-green-800 hover:underline">← Kembali ke Dashboard</a>
    </main>

</body>
</html>
