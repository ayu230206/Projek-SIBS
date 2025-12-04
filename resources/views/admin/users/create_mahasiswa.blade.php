@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Tambah Akun Mahasiswa (Otomatis)</div>
        <div class="card-body">
            <form action="{{ route('admin.users.store_mahasiswa') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required placeholder="Contoh: Budi Santoso">
                    <small class="text-muted">Email akan digenerate otomatis dari nama depan (budi@mahasiswa...).</small>
                </div>

                <div class="mb-3">
                    <label>Asal Kampus</label>
                    <select name="asal_kampus" class="form-control" required>
                        <option value="">-- Pilih Kampus --</option>
                        @foreach($kampus as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kampus }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Angkatan</label>
                    <input type="number" name="angkatan" class="form-control" required placeholder="Contoh: 2024">
                </div>

                <button type="submit" class="btn btn-primary">Generate Akun</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection