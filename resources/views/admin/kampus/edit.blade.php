@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Kampus</div>
        <div class="card-body">
            <form action="{{ route('admin.kampus.update', $kampus->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Nama Kampus</label>
                    <input type="text" name="nama_kampus" class="form-control" value="{{ $kampus->nama_kampus }}" required>
                </div>
                <div class="mb-3">
                    <label>Kode Kampus</label>
                    <input type="text" name="kode_kampus" class="form-control" value="{{ $kampus->kode_kampus }}">
                </div>
                <div class="mb-3">
                    <label>Status Kerjasama</label>
                    <select name="status_kerjasama" class="form-select">
                        <option value="aktif" {{ $kampus->status_kerjasama == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $kampus->status_kerjasama == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="pending" {{ $kampus->status_kerjasama == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ditolak" {{ $kampus->status_kerjasama == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.kampus.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection