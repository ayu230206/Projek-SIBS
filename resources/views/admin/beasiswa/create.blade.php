@extends('admin.layout.LayoutAdmin')

@section('title', 'Buat Program Beasiswa Baru')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 800px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Formulir Program Beasiswa Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.beasiswa.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Program</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="isi_informasi" class="form-label">Detail Informasi Program</label>
                <textarea class="form-control @error('isi_informasi') is-invalid @enderror" id="isi_informasi" name="isi_informasi" rows="5" required>{{ old('isi_informasi') }}</textarea>
                @error('isi_informasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Pendaftaran</label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir Pendaftaran</label>
                    <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
                    @error('tanggal_berakhir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Program</button>
            </div>
        </form>
    </div>
</div>
@endsection