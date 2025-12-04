@extends('admin.layout.LayoutAdmin')

@section('title', 'Verifikasi Dokumen: ' . ($mahasiswaDetail->user->nama_lengkap ?? ''))

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Mahasiswa</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $mahasiswaDetail->user->nama_lengkap ?? 'N/A' }}</p>
                <p><strong>NIM:</strong> {{ $mahasiswaDetail->nim }}</p>
                <p><strong>Kampus:</strong> {{ $mahasiswaDetail->kampus->nama_kampus ?? 'N/A' }}</p>
                <p><strong>Program Studi:</strong> {{ $mahasiswaDetail->program_studi }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-lg">
            <div class="card-header bg-white">
                <h5 class="mb-0">Daftar Dokumen yang Diperlukan</h5>
            </div>
            <div class="card-body">
                {{-- Contoh Daftar Dokumen --}}
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Kartu Tanda Penduduk (KTP)
                        <div>
                            @if ($mahasiswaDetail->path_ktp)
                                <a href="{{ asset('storage/' . $mahasiswaDetail->path_ktp) }}" target="_blank" class="btn btn-sm btn-info me-2"><i class="fas fa-file-download"></i> Lihat</a>
                                <form action="{{ route('admin.mahasiswa.dokumen.verifikasi', $mahasiswaDetail->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status_verifikasi_ktp" value="1">
                                    <button type="submit" class="btn btn-sm btn-success">Verifikasi</button>
                                </form>
                            @else
                                <span class="text-danger">Belum Diunggah</span>
                            @endif
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Kartu Hasil Studi (KHS) Terakhir
                        <div>
                            {{-- ... Logic Dokumen KHS ... --}}
                            <span class="text-muted">Status: Belum Cek</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('admin.mahasiswa.dokumen.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>
@endsection