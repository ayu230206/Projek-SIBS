@extends('admin.layout.LayoutAdmin')

@section('title', 'Edit Nilai Akademik')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit Nilai Akademik</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <strong>Mahasiswa:</strong> {{ $mahasiswaDetail->user->nama_lengkap ?? 'N/A' }} (NIM: {{ $mahasiswaDetail->nim }})
        </div>
        
        <form action="{{ route('admin.mahasiswa.akademik.update', $mahasiswaDetail->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="ips_terakhir" class="form-label">IPS Terakhir</label>
                <input type="number" step="0.01" class="form-control @error('ips_terakhir') is-invalid @enderror" id="ips_terakhir" name="ips_terakhir" value="{{ old('ips_terakhir', $mahasiswaDetail->ips_terakhir) }}" required min="0" max="4">
                @error('ips_terakhir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="ipk" class="form-label">IPK Kumulatif</label>
                <input type="number" step="0.01" class="form-control @error('ipk') is-invalid @enderror" id="ipk" name="ipk" value="{{ old('ipk', $mahasiswaDetail->ipk) }}" required min="0" max="4">
                @error('ipk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.mahasiswa.akademik.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection