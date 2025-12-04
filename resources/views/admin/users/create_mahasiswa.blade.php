@extends('admin.layout.LayoutAdmin')

@section('title', 'Tambah Akun Mahasiswa')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Akun Mahasiswa (Otomatis)</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store_mahasiswa') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" required placeholder="Contoh: Budi Santoso" value="{{ old('nama_lengkap') }}">
                    <small class="text-muted">Email dan password akan digenerate otomatis.</small>
                    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Asal Kampus</label>
                    <select name="asal_kampus" class="form-select @error('asal_kampus') is-invalid @enderror" required>
                        <option value="">-- Pilih Kampus --</option>
                        @foreach($kampus as $k)
                            <option value="{{ $k->id }}" {{ old('asal_kampus') == $k->id ? 'selected' : '' }}>{{ $k->nama_kampus }}</option>
                        @endforeach
                    </select>
                    @error('asal_kampus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Angkatan</label>
                    <input type="number" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror" required placeholder="Contoh: 2024" value="{{ old('angkatan') }}">
                    @error('angkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-robot me-1"></i> Generate & Simpan Akun</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection