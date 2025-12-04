@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Edit User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                {{-- Logic khusus jika user adalah mahasiswa --}}
                @if($user->role == 'mahasiswa')
                <div class="mb-3">
                    <label class="form-label">Asal Kampus</label>
                    <select name="asal_kampus" class="form-select">
                        @foreach($kampus as $k)
                            <option value="{{ $k->id }}" {{ $user->asal_kampus == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="role" value="mahasiswa">
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="bpdpks" {{ $user->role == 'bpdpks' ? 'selected' : '' }}>BPDPKS</option>
                    </select>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label text-muted">Password Baru (Biarkan kosong jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control" placeholder="Isi hanya jika ingin ganti password">
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection