@extends('admin.layout.LayoutAdmin')

@section('content')
<div class="container">
    <div class="card w-50 mx-auto">
        <div class="card-header">Update Nilai: {{ $mahasiswaDetail->user->nama_lengkap }}</div>
        <div class="card-body">
            <form action="{{ route('admin.mahasiswa.akademik.update', $mahasiswaDetail->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>IPK (Indeks Prestasi Kumulatif)</label>
                    <input type="number" step="0.01" min="0" max="4.00" name="ipk" class="form-control" value="{{ $mahasiswaDetail->ipk }}" required>
                </div>

                <div class="mb-3">
                    <label>Semester Berjalan</label>
                    <input type="number" name="semester_berjalan" class="form-control" value="{{ $mahasiswaDetail->semester_berjalan }}" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection