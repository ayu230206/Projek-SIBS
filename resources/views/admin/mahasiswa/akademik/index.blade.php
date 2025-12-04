@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <h3>Data Akademik Mahasiswa</h3>
    <div class="mb-3 text-end">
        {{-- Tombol dummy import --}}
        <a href="{{ route('admin.mahasiswa.akademik.import.form') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Import Excel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kampus</th>
                        <th>IPK Saat Ini</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataMahasiswa as $mhs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mhs->user->nama_lengkap ?? '-' }}</td>
                        <td>{{ $mhs->kampus->nama_kampus ?? '-' }}</td>
                        <td class="fw-bold text-center">{{ $mhs->ipk ?? '0.00' }}</td>
                        <td class="text-center">{{ $mhs->semester_berjalan ?? 1 }}</td>
                        <td>
                            <a href="{{ route('admin.mahasiswa.akademik.edit', $mhs->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Update Nilai
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $dataMahasiswa->links() }}
        </div>
    </div>
</div>
@endsection