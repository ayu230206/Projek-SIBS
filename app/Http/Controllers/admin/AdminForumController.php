<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import Model
use App\Models\Mahasiswa\Post; // Model Post Forum Mahasiswa
use App\Models\ActivityLog;    // Model Log Aktivitas

class AdminForumController extends Controller
{
    /**
     * Menampilkan daftar semua postingan forum mahasiswa.
     */
    public function index(Request $request)
    {
        // Ambil postingan terbaru dengan data penulisnya
        $query = Post::with('user')->latest();

        // Fitur Pencarian Sederhana (Opsional, jika ingin cari isi konten)
        if ($request->filled('search')) {
            $query->where('isi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
                  });
        }

        $posts = $query->paginate(10);

        return view('admin.forum.index', compact('posts'));
    }

    /**
     * Menghapus postingan yang tidak pantas.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Simpan data untuk log sebelum dihapus
        $penulis = $post->user->nama_lengkap ?? 'Mahasiswa';
        $cuplikanIsi = Str::limit($post->isi, 30);

        // Hapus Postingan
        $post->delete();

        // --- CATAT LOG AKTIVITAS ---
        if (class_exists(ActivityLog::class)) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Hapus Post Forum',
                'description' => Auth::user()->nama_lengkap . " menghapus postingan milik $penulis: '$cuplikanIsi'"
            ]);
        }
        // ---------------------------

        return back()->with('success', 'Postingan forum berhasil dihapus dan dicatat di log.');
    }
}