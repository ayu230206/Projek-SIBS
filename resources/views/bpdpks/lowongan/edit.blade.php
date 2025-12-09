@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Edit Lowongan & Magang')

@section('content')
<div class="header">
    <h1 class="welcome"><i class="fas fa-edit me-2"></i> Edit Lowongan / Magang</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-custom">
<form action="{{ route('bpdpks.lowongan.update', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Tipe Iklan <span class="text-danger">*</span></label>
        <select class="form-select" id="tipe" name="tipe">
            <option value="magang" {{ $lowongan->tipe == 'magang' ? 'selected' : '' }}>Magang</option>
            <option value="lowongan_kerja" {{ $lowongan->tipe == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Deadline</label>
        <input type="date" class="form-control" id="deadline" name="deadline" value="{{ $lowongan->deadline }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Lokasi</label>
        <input type="text" class="form-control" name="lokasi" value="{{ $lowongan->lokasi }}">
    </div>
</div>

@if($lowongan->tipe == 'lowongan_kerja')
<div class="mb-3" id="gajiField">
    <label class="form-label">Gaji</label>
    <input type="text" class="form-control" name="gaji" value="{{ $lowongan->gaji }}">
</div>
@endif

@if($lowongan->tipe == 'magang')
<div class="row" id="magangField">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" class="form-control" name="tanggal_mulai" value="{{ $lowongan->tanggal_mulai }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" class="form-control" name="tanggal_selesai" value="{{ $lowongan->tanggal_selesai }}">
    </div>
</div>
@endif

<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" class="form-control" name="judul" value="{{ $lowongan->judul }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea class="form-control" name="deskripsi" rows="5">{{ $lowongan->deskripsi }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Kualifikasi</label>
    <textarea class="form-control" name="kualifikasi" rows="5">{{ $lowongan->kualifikasi }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Foto Lowongan (opsional)</label>
    @if($lowongan->foto)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $lowongan->foto) }}" alt="Foto Lowongan" class="img-thumbnail" width="150">
        </div>
    @endif
    <input type="file" name="foto" accept="image/*" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">File Pendukung (PDF, opsional)</label>
    @if($lowongan->file_pendukung)
        <div class="mb-2">
            <a href="{{ asset('storage/' . $lowongan->file_pendukung) }}" target="_blank">Lihat File Pendukung</a>
        </div>
    @endif
    <input type="file" name="file_pendukung" accept="application/pdf" class="form-control">
</div>

<hr>
<button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
<a href="{{ route('bpdpks.lowongan.index') }}" class="btn btn-secondary">Batal</a>
</form>
</div>

<script>
document.getElementById('tipe').addEventListener('change', function(){
    location.reload(); // field menyesuaikan otomatis
});
</script>

@endsection
