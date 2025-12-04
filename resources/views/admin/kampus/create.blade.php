@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Tambah Kampus Mitra</div>
        <div class="card-body">
            <form action="{{ route('admin.kampus.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Kampus</label>
                    <input type="text" name="nama_kampus" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kode Kampus (Opsional)</label>
                    <input type="text" name="kode_kampus" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Status Kerjasama</label>
                    <select name="status_kerjasama" class="form-select">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.kampus.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection