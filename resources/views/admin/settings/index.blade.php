@extends('admin.layout.LayoutAdmin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Pengaturan Website</h5>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row align-items-center mb-4">
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-bold">Logo Saat Ini</label>
                            <div class="border p-2 rounded bg-light">
                                <img src="{{ asset($logoPath) }}?v={{ time() }}" alt="Website Logo" class="img-fluid" style="max-height: 150px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('admin.logo.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Ganti Logo Website</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*" required>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PNG, JPG, JPEG. Maks: 2MB.</small>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Simpan Logo
                                </button>
                            </form>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i> Pengaturan lainnya dapat ditambahkan di sini (misal: Judul Website, Email Admin, dll).
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection