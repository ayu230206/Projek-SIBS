@extends('admin.layout.LayoutAdmin')

@section('title', 'Mass Upload Nilai Akademik')

@section('content')
<div class="card shadow-lg mx-auto" style="max-width: 600px;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-file-excel me-2"></i>Mass Upload Data Akademik</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i> Pastikan format file Anda sesuai dengan template (NIM, IPS, IPK).
        </div>
        
        <form action="{{ route('admin.mahasiswa.akademik.import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="file" class="form-label fw-bold">Pilih File Excel/CSV</label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required accept=".xlsx, .xls, .csv">
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-upload me-1"></i> Upload dan Proses Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection