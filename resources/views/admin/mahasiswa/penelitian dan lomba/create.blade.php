@extends('admin.layout.LayoutAdmin')

@section('title', 'Tambah Penelitian/Lomba Baru')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 700px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Formulir Tambah Penelitian/Lomba</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.penelitian-lomba.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="tipe" class="form-label">Tipe Kegiatan</label>
                <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="penelitian" {{ old('tipe') == 'penelitian' ? 'selected' : '' }}>Penelitian/Riset</option>
                    <option value="lomba" {{ old('tipe') == 'lomba' ? 'selected' : '' }}>Lomba/Kompetisi</option>
                </select>
                @error('tipe')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Kegiatan</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="penyelenggara" class="form-label">Penyelenggara</label>
                <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}">
                @error('penyelenggara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.penelitian-lomba.store') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection