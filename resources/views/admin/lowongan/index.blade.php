@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container-fluid px-4"> <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <div class="title-section">
            <h1 class="welcome display-5 fw-bold text-dark">
                <i class="fas fa-bullhorn me-2"></i>Manajemen Lowongan & Magang
            </h1>
            <p class="text-muted fs-5">Kelola daftar lowongan kerja dan kesempatan magang untuk mahasiswa beasiswa.</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary btn-lg shadow-sm" style="background-color: var(--primary); border-color: var(--primary);">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card border-0 shadow-sm mb-4 bg-white rounded-3">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-3"><i class="fas fa-filter me-2"></i>Filter Data</h5>
            <form action="{{ route('admin.lowongan.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label fw-semibold text-dark">Cari Judul Lowongan</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Ketik judul lowongan...">
                </div>
                <div class="col-md-3">
                    <label for="tipe_filter" class="form-label fw-semibold text-dark">Tipe</label>
                    <select class="form-select" id="tipe_filter" name="tipe">
                        <option value="semua" {{ request('tipe') == 'semua' ? 'selected' : '' }}>Semua Tipe</option>
                        <option value="magang" {{ request('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                        <option value="lowongan_kerja" {{ request('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-info text-white flex-grow-1">
                        <i class="fas fa-search me-1"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary flex-grow-1">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white rounded-3">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-3">Daftar Lowongan & Magang</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="lowonganTable">
                    <thead class="table-light"> <tr>
                            <th class="text-dark">#</th>
                            <th class="text-dark">Judul</th>
                            <th class="text-dark">Tipe</th>
                            <th class="text-dark">Deadline</th>
                            <th class="text-dark">Pelamar</th>
                            <th class="text-dark">Diinput Oleh</th>
                            <th class="text-dark">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowongans as $lowongan)
                        <tr>
                            <td>{{ $loop->iteration + ($lowongans->perPage() * ($lowongans->currentPage() - 1)) }}</td>
                            <td class="fw-semibold">{{ $lowongan->judul }}</td>
                            <td>{!! $lowongan->getTipeBadge() !!}</td>
                            <td>
                                @if($lowongan->deadline)
                                    <span class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Ada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.lowongan.monitoring', $lowongan->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-users me-1"></i> {{ $lowongan->aplikasi_count }} Pelamar
                                </a>
                            </td>
                            <td>{{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" 
                                       class="btn btn-sm btn-warning text-white" 
                                       title="Edit Lowongan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('bpdpks.lowongan.destroy', $lowongan->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Menghapus akan menghapus semua aplikasi yang masuk.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus Lowongan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block opacity-50"></i>
                                Tidak ada lowongan atau magang yang tersedia saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $lowongans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection