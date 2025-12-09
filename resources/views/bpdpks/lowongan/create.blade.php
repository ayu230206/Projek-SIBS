@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Tambah Lowongan & Magang')

@section('content')
<div class="header">
    <h1 class="welcome"><i class="fas fa-plus me-2"></i> Tambah Lowongan / Magang Baru</h1>
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
    <form action="{{ route('bpdpks.lowongan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Tipe Iklan <span class="text-danger">*</span></label>
                <select class="form-select" id="tipe" name="tipe" required>
                    <option value="magang">Magang</option>
                    <option value="lowongan_kerja">Lowongan Kerja</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Deadline <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="deadline" name="deadline">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi">
            </div>
        </div>

        <div class="mb-3" id="gajiField" style="display:none;">
            <label class="form-label">Gaji (Opsional)</label>
            <input type="text" class="form-control" name="gaji">
        </div>

        <div class="row" id="magangField" style="display:none;">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggal_mulai">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" name="tanggal_selesai">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="judul" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Kualifikasi</label>
            <textarea class="form-control" name="kualifikasi" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Lowongan (opsional)</label>
            <input type="file" name="foto" accept="image/*" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">File Pendukung (PDF, opsional)</label>
            <input type="file" name="file_pendukung" accept="application/pdf" class="form-control">
        </div>

        <hr>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan Lowongan
        </button>
        <a href="{{ route('bpdpks.lowongan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
document.getElementById('tipe').addEventListener('change', function(){
    let tipe = this.value;
    document.getElementById('gajiField').style.display = (tipe === 'lowongan_kerja') ? 'block' : 'none';
    document.getElementById('magangField').style.display = (tipe === 'magang') ? 'block' : 'none';
});
</script>

@endsection
