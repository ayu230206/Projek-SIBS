@extends('admin.layout.LayoutAdmin')

@section('title', 'Edit Data Penelitian dan Lomba')

@section('content')

<div class="card shadow-lg mx-auto" style="max-width: 800px;">
<div class="card-header bg-warning text-dark">
<h5 class="mb-0">Edit Data Penelitian dan Lomba</h5>
</div>
<div class="card-body">
<form action="{{ route('admin.penelitian-lomba.update', $penelitianLomba->id) }}" method="POST">
@csrf
@method('PUT')

        {{-- Tipe (Penelitian atau Lomba) --}}
        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe Kegiatan</label>
            <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                <option value="">Pilih Tipe</option>
                <option value="penelitian" {{ old('tipe', $penelitianLomba->tipe) == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                <option value="lomba" {{ old('tipe', $penelitianLomba->tipe) == 'lomba' ? 'selected' : '' }}>Lomba</option>
            </select>
            @error('tipe')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Judul Kegiatan --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Kegiatan</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $penelitianLomba->judul) }}" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Penyelenggara --}}
        <div class="mb-3">
            <label for="penyelenggara" class="form-label">Penyelenggara</label>
            <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara', $penelitianLomba->penyelenggara) }}">
            @error('penyelenggara')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi/Keterangan --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi / Keterangan Lengkap</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $penelitianLomba->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-end mt-4">
            {{-- Menggunakan route index yang benar (admin.penelitian-lomba.index) --}}
            <a href="{{ route('admin.penelitian-lomba.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui Data</button>
        </div>
    </form>
</div>


</div>
@endsection