@extends('admin.layout.LayoutAdmin')

@section('title', 'Input Nilai Akademik Mahasiswa')

@section('content')

<div class="card shadow-lg mx-auto" style="max-width: 600px;">
<div class="card-header bg-primary text-white">
<h5 class="mb-0">Input Nilai Akademik</h5>
</div>
<div class="card-body">

    <!-- Informasi Mahasiswa yang akan diupdate -->
    <div class="alert alert-info">
        <p class="mb-1"><strong>Mahasiswa:</strong> {{ $mahasiswaDetail->user->name ?? 'N/A' }}</p>
        <p class="mb-0"><strong>NIM:</strong> {{ $mahasiswaDetail->nim ?? 'N/A' }}</p>
        <p class="mb-0"><strong>Program Studi:</strong> {{ $mahasiswaDetail->prodi ?? 'N/A' }}</p>
    </div>

    <form action="{{ route('admin.mahasiswa.akademik.store') }}" method="POST">
        @csrf
        
        {{-- Hidden field untuk user_id yang dibutuhkan oleh method store --}}
        <input type="hidden" name="user_id" value="{{ $mahasiswaDetail->user_id }}">

        <div class="mb-3">
            <label for="ipk" class="form-label">Indeks Prestasi Kumulatif (IPK)</label>
            <input type="number" step="0.01" min="0.00" max="4.00" class="form-control @error('ipk') is-invalid @enderror" id="ipk" name="ipk" 
                   value="{{ old('ipk', $mahasiswaDetail->ipk) }}" required>
            @error('ipk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Contoh: 3.75 (Maksimal 4.00)</small>
        </div>

        <div class="mb-3">
            <label for="ips_terakhir" class="form-label">Indeks Prestasi Semester (IPS) Terakhir</label>
            <input type="number" step="0.01" min="0.00" max="4.00" class="form-control @error('ips_terakhir') is-invalid @enderror" id="ips_terakhir" name="ips_terakhir" 
                   value="{{ old('ips_terakhir', $mahasiswaDetail->ips_terakhir) }}" required>
            @error('ips_terakhir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Contoh: 4.00 (Untuk semester terakhir)</small>
        </div>
        
        <hr>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('admin.mahasiswa.akademik.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-success">Simpan Nilai</button>
        </div>
    </form>
</div>


</div>
@endsection