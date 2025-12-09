{{-- Hapus 'bg-dark', ganti dengan style background-color: var(--palm-green) --}}
<footer class="footer p-3 text-white" style="background-color: var(--palm-green); border-top: 1px solid rgba(255,255,255,0.1);">
    <div class="container text-center">
        {{-- Menggunakan text-white agar tulisan jelas di atas hijau --}}
        <p class="mb-0 small">&copy; {{ date('Y') }} Beasiswa Sawit. All rights reserved.</p>
    </div>
</footer>