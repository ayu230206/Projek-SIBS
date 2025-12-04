@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <h4>Tambah Lowongan Baru</h4>
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('admin.lowongan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Judul Lowongan</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tipe</label>
                    <select name="tipe" class="form-select">
                        <option value="magang">Magang</option>
                        <option value="lowongan_kerja">Lowongan Kerja</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Kualifikasi (Opsional)</label>
                    <textarea name="kualifikasi" rows="3" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Batas Akhir (Deadline)</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Publish</button>
            </form>
        </div>
    </div>
</div>
@endsection