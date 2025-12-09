@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Detail Lamaran')

@section('content')
<div class="card-custom p-4">
    <h4 class="mb-3"><i class="fas fa-user me-2"></i> Data Pelamar</h4>

    <p><strong>Nama:</strong> {{ $aplikasi->mahasiswa->nama_lengkap }}</p>
    <p><strong>Email:</strong> {{ $aplikasi->mahasiswa->email }}</p>
    <p><strong>Kampus:</strong> 
        {{ $aplikasi->mahasiswa->detail->kampus->nama_kampus ?? '-' }}
    </p>
    <p><strong>Status Aplikasi:</strong> {!! $aplikasi->getStatusBadge() !!}</p>

    <hr>

    <h5 class="mt-3"><i class="fas fa-file-alt me-2"></i> Dokumen Lamaran</h5>

    {{-- CV --}}
    <div class="mt-3">
        <strong>Curriculum Vitae (CV):</strong><br>
        @if($cv)
            {{-- Tombol Lihat (membuka di tab baru) --}}
            <a href="{{ asset('storage/' . $cv) }}" 
                target="_blank"
                class="btn btn-sm btn-info mt-1 text-white">
                 <i class="fas fa-eye me-1"></i> Lihat
            </a>
            
            {{-- Tombol Download: Menggunakan URL Storage langsung --}}
            <a href="{{ asset('storage/' . $cv) }}" 
                download 
                class="btn btn-sm btn-success mt-1">
                 <i class="fas fa-download me-1"></i> Download CV
            </a>
        @else
            <span class="text-danger">CV belum diunggah</span>
        @endif
    </div>

    {{-- PORTOFOLIO --}}
    <div class="mt-3">
        <strong>Portofolio:</strong><br>
        @if($portofolio)
            {{-- Tombol Lihat (membuka di tab baru) --}}
            <a href="{{ asset('storage/' . $portofolio) }}" 
                target="_blank"
                class="btn btn-sm btn-info mt-1 text-white">
                 <i class="fas fa-eye me-1"></i> Lihat
            </a>
            
            {{-- Tombol Download: Menggunakan URL Storage langsung --}}
            <a href="{{ asset('storage/' . $portofolio) }}" 
                download
                class="btn btn-sm btn-success mt-1">
                 <i class="fas fa-download me-1"></i> Download Portofolio
            </a>
        @else
            <span class="text-secondary">Portofolio tidak diunggah</span>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection