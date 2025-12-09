@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Kampus & Kerjasama')

@section('content')

<style>
    /* Header Modern */
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

    /* Tombol Tambah */
    .btn-add {
        padding: 12px 18px;
        font-size: .9rem;
        font-weight: 600;
        border-radius: 12px;
        transition: .25s ease;
        background: #bfa15a;
        border-color: #bfa15a;
        color: #fff;
    }

    .btn-add:hover {
        background: #8f7d4a !important;
        transform: translateY(-2px);
    }

    /* Card Custom */
    .card-custom {
        background: #ffffff;
        padding: 22px 24px;
        border-radius: 16px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        border: none;
        margin-bottom: 25px;
    }

    /* Judul Section */
    .section-title {
        font-weight: 600;
        margin-bottom: 14px;
        font-size: 1rem;
    }
</style>

<div class="header-modern">
    <div>
        <h1><i class="fas fa-university me-2"></i> Data Kampus & Kerjasama</h1>
        <p>Manajemen daftar universitas dan status kerjasama dengan BPDPKS.</p>
    </div>
    <a href="{{ route('bpdpks.kerjasama.create') }}" class="btn btn-add">
        <i class="fas fa-plus me-1"></i> Tambah Kampus
    </a>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card-custom">
    <h5 class="section-title"><i class="fas fa-filter me-2"></i> Filter Data Kampus</h5>
    <form action="{{ route('bpdpks.kerjasama.index') }}" method="GET" class="row g-3">
        <div class="col-md-5">
            <label for="search" class="form-label">Cari Nama/Kode Kampus</label>
            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama atau Kode Kampus">
        </div>
        <div class="col-md-3">
            <label for="status_aktif" class="form-label">Status Kerjasama</label>
            <select class="form-select" id="status_aktif" name="status_aktif">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status_aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status_aktif') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-info text-white me-2">Terapkan Filter</button>
            <a href="{{ route('bpdpks.kerjasama.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card-custom">
    <h5 class="section-title"><i class="fas fa-list me-2"></i> Daftar Kampus Mitra BPDPKS</h5>
    <div class="table-responsive">
        <table class="table table-hover" id="kampusTable">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kampus</th>
                    <th>Kode</th>
                    <th>Status</th>
                    <th>Tanggal MoU</th>
                    <th class="text-nowrap" style="width: 150px;">Aksi</th> 
                </tr>
            </thead>
            <tbody>
                @forelse ($dataKampus as $kampus)
                <tr>
                    <td>{{ $loop->iteration + ($dataKampus->perPage() * ($dataKampus->currentPage() - 1)) }}</td>
                    <td>{{ $kampus->nama_kampus }}</td>
                    <td>{{ $kampus->kode_kampus ?? '-' }}</td>
                    <td>{!! $kampus->getStatusBadge() !!}</td>
                    <td>{{ $kampus->tanggal_mou ? \Carbon\Carbon::parse($kampus->tanggal_mou)->format('d M Y') : 'N/A' }}</td>
                    <td class="d-flex text-nowrap"> 
                        <a href="{{ route('bpdpks.kerjasama.edit', $kampus->id) }}" class="btn btn-sm btn-warning me-1" title="Edit Data">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('bpdpks.kerjasama.destroy', $kampus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kampus ini? Penghapusan akan gagal jika masih ada mahasiswa terdaftar.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data kampus yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $dataKampus->links() }}
    </div>
</div>

@endsection

@section('scripts')
{{-- Tempat untuk script tambahan --}}
@endsection
