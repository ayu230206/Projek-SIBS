@extends('admin.layout.LayoutAdmin')

@section('title', 'Daftar Penelitian dan Lomba')

@section('content')

<div class="container-fluid">
<!-- Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Daftar Program Penelitian dan Lomba</h1>
<a href="{{ route('admin.penelitian-lomba.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Program Baru
</a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Program Penelitian dan Lomba</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Program</th>
                        <th>Deskripsi Singkat</th>
                        <th>Periode Pendaftaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh loop data. Pastikan nama variabel sesuai dengan yang dikirim dari controller --}}
                    @forelse ($dataPenelitianLomba as $program)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $program->judul }}</td>
                        <td>{{ Str::limit($program->deskripsi, 80) }}</td>
                        <td>{{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($program->tanggal_berakhir)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.penelitian-lomba.edit', $program->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.penelitian-lomba.destroy', $program->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data Program Penelitian dan Lomba.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>

<script>
// Hanya perlu jika Anda menggunakan library DataTables atau JS kustom
document.addEventListener('DOMContentLoaded', function() {
// Asumsi DataTables sudah dimuat
// $('#dataTable').DataTable();
});
</script>

@endsection