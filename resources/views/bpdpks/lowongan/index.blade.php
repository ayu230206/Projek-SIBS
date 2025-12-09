@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Manajemen Lowongan & Magang')

@section('content')

<style>
    .header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary);
        padding: 22px 28px;
        border-radius: 18px;
        color: #fff;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        margin-bottom: 25px;
    }

    .header-modern h1 {
        font-size: 1.55rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-modern p {
        font-size: .92rem;
        opacity: .85;
        margin: 2px 0 0 0;
    }

    .btn-add {
        padding: 12px 18px;
        font-size: .9rem;
        font-weight: 600;
        border-radius: 12px;
        transition: .25s ease;
        background: #bfa15a;
        border-color: #bfa15a;
    }

    .btn-add:hover {
        background: #8f7d4a !important;
        transform: translateY(-2px);
    }

    .card-custom {
        background: #ffffff;
        padding: 22px 24px;
        border-radius: 16px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        border: none;
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 14px;
        font-size: 1rem;
    }
</style>

<div class="header-modern">
    <div>
        <h1><i class="fas fa-bullhorn"></i> Manajemen Lowongan & Magang</h1>
        <p>Kelola daftar lowongan kerja dan kesempatan magang untuk mahasiswa beasiswa.</p>
    </div>

    <a href="{{ route('bpdpks.lowongan.create') }}" class="btn text-white btn-add">
        <i class="fas fa-plus me-1"></i> Tambah Lowongan / Magang
    </a>
</div>


@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    

<div class="card-custom mb-4">
    <h5 class="section-title"><i class="fas fa-filter me-2"></i> Filter Data</h5>
    <form action="{{ route('bpdpks.lowongan.index') }}" method="GET" class="row g-3">
        <div class="col-md-5">
            <label for="search" class="form-label">Cari Judul Lowongan</label>
            <input type="text" class="form-control" id="search" name="search"
                   value="{{ request('search') }}" placeholder="Judul Lowongan/Magang">
        </div>
        <div class="col-md-3">
            <label for="tipe_filter" class="form-label">Tipe</label>
            <select class="form-select" id="tipe_filter" name="tipe">
                <option value="semua" {{ request('tipe') == 'semua' ? 'selected' : '' }}>Semua Tipe</option>
                <option value="magang" {{ request('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                <option value="lowongan_kerja" {{ request('tipe') == 'lowongan_kerja' ? 'selected' : '' }}>Lowongan Kerja</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-info text-white me-2">Terapkan Filter</button>
            <a href="{{ route('bpdpks.lowongan.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>


@if ($pendingAplikasiCount > 0)
<div class="alert alert-warning mb-4">
    <i class="fas fa-exclamation-triangle me-2"></i>
    Ada <strong>{{ $pendingAplikasiCount }}</strong> aplikasi magang/lowongan yang <strong>perlu ditinjau!</strong>
</div>
@endif


<div class="card-custom">
    <h5 class="section-title"><i class="fas fa-list me-2"></i> Daftar Lowongan & Magang</h5>
    <div class="table-responsive">
        <table class="table table-hover datatable" id="lowonganTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Deadline</th>
                    <th>Pelamar</th>
                    <th>Diinput Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowongans as $lowongan)
                <tr>
                    <td>{{ $loop->iteration + ($lowongans->perPage() * ($lowongans->currentPage() - 1)) }}</td>
                    <td>{{ $lowongan->judul }}</td>
                    <td>{!! $lowongan->getTipeBadge() !!}</td>
                    <td>{{ $lowongan->deadline ? \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') : 'Tidak Ada' }}</td>
                    <td>
                        <a href="{{ route('bpdpks.lowongan.monitoring', $lowongan->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-users me-1"></i> {{ $lowongan->aplikasi_count }} Pelamar
                        </a>
                    </td>
                    <td>{{ $lowongan->diinputOleh->nama_lengkap ?? 'Admin' }}</td>

                    <td>
                        <a href="{{ route('bpdpks.lowongan.edit', $lowongan->id) }}" class="btn btn-sm btn-warning me-1" title="Edit Lowongan">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        
                        <form action="{{ route('bpdpks.lowongan.destroy', $lowongan->id) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Menghapus akan menghapus semua aplikasi yang masuk.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Lowongan">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada lowongan atau magang yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $lowongans->links() }}
    </div>
</div>

@endsection
