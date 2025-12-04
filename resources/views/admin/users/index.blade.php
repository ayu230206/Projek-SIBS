@extends('admin.layout.LayoutAdmin') {{-- Sesuaikan dengan layout utama admin Anda --}}

@section('content')
<div class="container">
    <h1>Manajemen User</h1>
    
    {{-- Notifikasi Khusus Password Baru (Hasil Auto Generate) --}}
    @if (session('credentials'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading"><i class="fas fa-check-circle"></i> Akun Mahasiswa Berhasil Dibuat!</h4>
        <p>Mohon catat atau berikan detail login berikut kepada mahasiswa:</p>
        <hr>
        <ul>
            <li><strong>Nama:</strong> {{ session('credentials')['name'] }}</li>
            <li><strong>Email/Login:</strong> {{ session('credentials')['email'] }}</li>
            <li><strong>Password:</strong> <span class="badge bg-dark" style="font-size: 1.1em;">{{ session('credentials')['password'] }}</span></li>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="mb-3">
        {{-- Tombol untuk fitur spesial --}}
        <a href="{{ route('admin.users.create_mahasiswa') }}" class="btn btn-primary">
            <i class="fas fa-user-graduate"></i> Tambah Mahasiswa (Auto)
        </a>
        
        {{-- Tombol standard --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-secondary">
            <i class="fas fa-user-plus"></i> Tambah Admin/BPDPKS
        </a>
    </div>

    {{-- Tabel User --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'bpdpks' ? 'warning' : 'success') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $users->links() }}
</div>
@endsection