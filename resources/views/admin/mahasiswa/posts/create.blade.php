@extends('layouts.mahasiswa.app')
@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full max-w-xl mx-auto mt-10">
    <h1 class="text-2xl font-bold text-green-900 mb-4">Buat Post Baru</h1>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('mahasiswa.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-green-800 font-semibold mb-2">Isi Post</label>
            <textarea name="isi" rows="4" class="w-full border border-green-300 rounded p-2" required>{{ old('isi') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-green-800 font-semibold mb-2">Gambar (opsional)</label>
            <input type="file" id="imageInput" name="gambar" accept="image/*" class="w-full">
        </div>
        <div class="mb-4">
            <img id="preview" class="hidden w-48 h-48 object-cover rounded-lg border border-green-300 shadow-sm">
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</a>
            <button type="submit" class="px-4 py-2 rounded bg-green-800 text-white hover:bg-green-900">Post</button>
        </div>
    </form>
</div>
<script>
document.getElementById('imageInput').addEventListener('change', function() {
    const preview = document.getElementById('preview');
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
