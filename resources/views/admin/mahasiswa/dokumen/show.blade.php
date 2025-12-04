@extends('admin.layout.LayoutAdmin')

@section('title', 'Periksa Dokumen: ' . ($mahasiswaDetail->user->nama_lengkap ?? ''))

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.mahasiswa.dokumen.index') }}" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>

    <div class="row">
        {{-- Kolom Kiri: Info Mahasiswa --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Mahasiswa</h5>
                </div>
                <div class="card-body text-center">
                    @if($mahasiswaDetail->path_foto_formal)
                        <img src="{{ asset('storage/' . $mahasiswaDetail->path_foto_formal) }}" class="img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 text-white" style="width: 150px; height: 150px; font-size: 3rem;">
                            {{ substr($mahasiswaDetail->user->nama_lengkap ?? 'U', 0, 1) }}
                        </div>
                    @endif
                    
                    <h4>{{ $mahasiswaDetail->user->nama_lengkap ?? 'Nama Tidak Ada' }}</h4>
                    <p class="text-muted">{{ $mahasiswaDetail->nim }}</p>
                    
                    <hr>
                    
                    <div class="text-start">
                        <p><strong>Kampus:</strong><br> {{ $mahasiswaDetail->kampus->nama_kampus ?? '-' }}</p>
                        <p><strong>Program Studi:</strong><br> {{ $mahasiswaDetail->program_studi }}</p>
                        <p><strong>Email:</strong><br> {{ $mahasiswaDetail->user->email ?? '-' }}</p>
                        <p><strong>Telepon:</strong><br> {{ $mahasiswaDetail->telepon ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Aksi Verifikasi --}}
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Aksi Verifikasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mahasiswa.dokumen.verifikasi', $mahasiswaDetail->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Keputusan Admin</label>
                            <select name="status_verifikasi" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="verified" class="text-success fw-bold">✅ Verifikasi (Terima)</option>
                                <option value="rejected" class="text-danger fw-bold">❌ Tolak Dokumen</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Berikan alasan jika ditolak..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save me-2"></i> Simpan Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Preview Dokumen --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" id="docTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ktp-tab" data-bs-toggle="tab" data-bs-target="#ktp" type="button" role="tab">KTP</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ktm-tab" data-bs-toggle="tab" data-bs-target="#ktm" type="button" role="tab">Kartu Mahasiswa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transkrip-tab" data-bs-toggle="tab" data-bs-target="#transkrip" type="button" role="tab">Transkrip Nilai</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="docTabsContent">
                        {{-- Tab KTP --}}
                        <div class="tab-pane fade show active" id="ktp" role="tabpanel">
                            <h5 class="card-title">Kartu Tanda Penduduk</h5>
                            @if($mahasiswaDetail->path_ktp)
                                <div class="ratio ratio-16x9 border bg-light">
                                    <iframe src="{{ asset('storage/' . $mahasiswaDetail->path_ktp) }}" allowfullscreen></iframe>
                                </div>
                                <div class="mt-2 text-end">
                                    <a href="{{ asset('storage/' . $mahasiswaDetail->path_ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning">Mahasiswa belum mengunggah KTP.</div>
                            @endif
                        </div>

                        {{-- Tab KTM --}}
                        <div class="tab-pane fade" id="ktm" role="tabpanel">
                            <h5 class="card-title">Kartu Tanda Mahasiswa</h5>
                            @if($mahasiswaDetail->path_kartu_mhs)
                                <div class="ratio ratio-16x9 border bg-light">
                                    <iframe src="{{ asset('storage/' . $mahasiswaDetail->path_kartu_mhs) }}" allowfullscreen></iframe>
                                </div>
                                <div class="mt-2 text-end">
                                    <a href="{{ asset('storage/' . $mahasiswaDetail->path_kartu_mhs) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning">Mahasiswa belum mengunggah KTM.</div>
                            @endif
                        </div>

                        {{-- Tab Transkrip --}}
                        <div class="tab-pane fade" id="transkrip" role="tabpanel">
                            <h5 class="card-title">Transkrip Nilai Terakhir</h5>
                            @if($mahasiswaDetail->path_transkrip_nilai)
                                <div class="ratio ratio-16x9 border bg-light">
                                    <iframe src="{{ asset('storage/' . $mahasiswaDetail->path_transkrip_nilai) }}" allowfullscreen></iframe>
                                </div>
                                <div class="mt-2 text-end">
                                    <a href="{{ asset('storage/' . $mahasiswaDetail->path_transkrip_nilai) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning">Mahasiswa belum mengunggah Transkrip Nilai.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection