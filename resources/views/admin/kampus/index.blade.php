@extends('admin.layout.LayoutAdmin')

@section('title', 'Data Kampus Mitra')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-university me-2"></i>Daftar Kampus Mitra & MoU</h3>
        <a href="{{ route('admin.kampus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Kampus
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.kampus.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama kampus atau kode..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.kampus.index') }}" class="btn btn-outline-secondary" title="Reset">
                            <i class="fas fa-sync"></i>
                        </a>
                    @endif
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Kampus</th>
                            <th>Kode</th>
                            <th>Status Kerjasama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataKampus as $kampus)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + $dataKampus->firstItem() - 1 }}</td>
                            <td>
                                <strong>{{ $kampus->nama_kampus }}</strong>
                                <br>
                                <small class="text-muted">MoU: {{ $kampus->nomor_mou ?? '-' }}</small>
                            </td>
                            <td>{{ $kampus->kode_kampus ?? '-' }}</td>
                            <td>
                                @if($kampus->status_kerjasama == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($kampus->status_kerjasama == 'nonaktif')
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                @elseif($kampus->status_kerjasama == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($kampus->status_kerjasama == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.kampus.edit', $kampus->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.kampus.destroy', $kampus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kampus ini? Data mahasiswa terkait mungkin akan error.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data kampus yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $dataKampus->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection