@extends('admin.layout.LayoutAdmin')

@section('title', 'Verifikasi Dokumen Mahasiswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-file-signature me-2"></i>Verifikasi Dokumen</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-gray-800">Daftar Kelengkapan Dokumen</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Status KTP</th>
                            <th>Status KTM</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswaDokumen as $data)
                        <tr>
                            <td>{{ $loop->iteration + $mahasiswaDokumen->firstItem() - 1 }}</td>
                            <td>
                                <strong>{{ $data->user->nama_lengkap ?? 'User Dihapus' }}</strong><br>
                                <small class="text-muted">{{ $data->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ $data->nim }}</td>
                            
                            {{-- Cek Ketersediaan Dokumen --}}
                            <td>
                                @if($data->path_ktp)
                                    <span class="badge bg-info">Terupload</span>
                                @else
                                    <span class="badge bg-secondary">Kosong</span>
                                @endif
                            </td>
                            <td>
                                @if($data->path_kartu_mhs)
                                    <span class="badge bg-info">Terupload</span>
                                @else
                                    <span class="badge bg-secondary">Kosong</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.mahasiswa.dokumen.show', $data->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-search me-1"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3"></i><br>
                                Belum ada data mahasiswa.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $mahasiswaDokumen->links() }}
        </div>
    </div>
</div>
@endsection