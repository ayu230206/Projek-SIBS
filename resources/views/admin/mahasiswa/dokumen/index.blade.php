@extends('admin.layout.LayoutAdmin')

@section('title', 'Verifikasi Dokumen Mahasiswa')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-white">
        <h4 class="mb-0">Daftar Mahasiswa untuk Verifikasi Dokumen</h4>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Status Kelengkapan Dokumen</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswaDokumen as $index => $data)
                        @php
                            // Simulasi status dokumen
                            $isComplete = $data->path_ktp && $data->path_kartu_mhs; // Ganti dengan logika nyata
                            $badgeClass = $isComplete ? 'bg-success' : 'bg-danger';
                            $statusText = $isComplete ? 'Lengkap' : 'Belum Lengkap';
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $data->nim }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ $statusText }}</span></td>
                            <td>
                                <a href="{{ route('admin.mahasiswa.dokumen.show', $data->id) }}" class="btn btn-sm btn-outline-info" title="Lihat dan Verifikasi">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data dokumen mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $mahasiswaDokumen->links() }}
    </div>
</div>
@endsection