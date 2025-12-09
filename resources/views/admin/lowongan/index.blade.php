@extends('admin.layout.LayoutAdmin')

@section('title', 'Manajemen Lowongan & Magang')

@section('content')

    <div class="header">
        <div class="title-section">
            <h1 class="welcome"><i class="fas fa-bullhorn me-2"></i> Manajemen Lowongan & Magang</h1>
            <p class="subtle">Kelola daftar lowongan kerja dan kesempatan magang untuk mahasiswa.</p>
        </div>
        <div class="controls">
            <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--palm-green); border-color: var(--palm-green);">
                <i class="fas fa-plus me-1"></i> Tambah Lowongan
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    {{-- Card Filter (Opsional, tapi bagus ada) --}}
    <div class="card-custom mb-4">
        <h5 class="section-title"><i class="fas fa-filter me-2"></i> Filter Data</h5>
        <form action="{{ route('admin.lowongan.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari Judul Lowongan...">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="tipe">
                    <option value="semua">Semua Tipe</option>
                    <option value="magang" {{ request('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                    <option value="lowongan_kerja" {{ request('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-info text-white"><i class="fas fa-search me-1"></i> Cari</button>
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary"><i class="fas fa-sync me-1"></i> Reset</a>
            </div>
        </form>
    </div>

    {{-- Tabel Data --}}
    <div class="card-custom">
        <h5 class="section-title"><i class="fas fa-list-ul me-2"></i> Daftar Lowongan Aktif</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable" id="lowonganTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="25%">Judul</th>
                        <th>Tipe</th>
                        
                        {{-- KOLOM BARU: FILE --}}
                        <th>File / Banner</th>
                        
                        <th>Deadline</th>
                        <th>Pelamar</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $lowongan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($lowongans->perPage() * ($lowongans->currentPage() - 1)) }}</td>
                        <td>
                            <span class="fw-bold text-dark">{{ $lowongan->judul }}</span>
                            <br>
                            <small class="text-muted">By: {{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin' }}</small>
                        </td>
                        <td>{!! $lowongan->getTipeBadge() !!}</td>
                        
                        {{-- LOGIKA MENAMPILKAN FILE --}}
                        <td>
                            @if($lowongan->file_path)
                                <a href="{{ asset($lowongan->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat File">
                                    <i class="fas fa-file-image me-1"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </td>

                        <td>
                            @if($lowongan->deadline)
                                {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}
                                @if(\Carbon\Carbon::parse($lowongan->deadline)->isPast())
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        
                        <td>
                            {{-- Link ke Monitoring Aplikasi --}}
                            <a href="{{ route('admin.lowongan.monitoring', $lowongan->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-users me-1"></i> {{ $lowongan->aplikasi_count ?? 0 }}
                            </a>
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.lowongan.destroy', $lowongan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini? Semua data pelamar juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i><br>
                            Belum ada lowongan atau magang yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $lowongans->withQueryString()->links() }}
        </div>
    </div>

@endsection