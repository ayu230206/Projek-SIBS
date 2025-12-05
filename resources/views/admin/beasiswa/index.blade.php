@extends('admin.layout.LayoutAdmin')

@section('title', 'Manajemen Program Beasiswa')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-white d-flex justify-content-between align-items-center fw-bold text-dark">
        <h4 class="mb-0">Daftar Program Beasiswa</h4>
        <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Program Baru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Judul Program</th>
                        <th>Jadwal Pendaftaran</th>
                        <th>Dibuat Oleh</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programs as $index => $program)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $program->judul }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($program->tanggal_berakhir)->format('d M Y') }}
                            </td>
                            <td>{{ $program->createdBy->nama_lengkap ?? 'Admin/BPDPKS' }}</td>
                            <td>
                                <a href="{{ route('admin.beasiswa.edit', $program->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.beasiswa.destroy', $program->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus program ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada Program Beasiswa yang diinput.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $programs->links() }}
    </div>
</div>
@endsection