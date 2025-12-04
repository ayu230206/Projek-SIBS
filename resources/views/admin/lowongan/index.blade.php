@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Kelola Lowongan & Magang</h2>
        <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Lowongan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowongans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>
                            <span class="badge bg-{{ $item->tipe == 'magang' ? 'warning' : 'info' }}">
                                {{ ucfirst(str_replace('_', ' ', $item->tipe)) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</td>
                        <td>
                            @if(\Carbon\Carbon::parse($item->deadline)->isPast())
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.lowongan.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.lowongan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lowongan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data lowongan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{-- Pagination --}}
            {{ $lowongans->links() }}
        </div>
    </div>
</div>
@endsection