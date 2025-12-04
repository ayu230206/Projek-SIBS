@extends('admin.layout.LayoutAdmin')

@section('title', 'Manajemen Nilai Akademik')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Daftar Nilai Akademik Mahasiswa</h4>
        <div>
            <a href="{{ route('admin.mahasiswa.akademik.import.form') }}" class="btn btn-warning me-2">
                <i class="fas fa-upload me-1"></i> Mass Upload Nilai
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kampus</th>
                        <th>IPS Terakhir</th>
                        <th>IPK Kumulatif</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswaAkademik as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->nim }}</td>
                            <td>{{ $data->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $data->kampus->nama_kampus ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $data->ips_terakhir ?? '-' }}</span></td>
                            <td><span class="badge bg-primary">{{ $data->ipk ?? '-' }}</span></td>
                            <td>
                                <a href="{{ route('admin.mahasiswa.akademik.edit', $data->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Nilai">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data akademik mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $mahasiswaAkademik->links() }}
    </div>
</div>
@endsection