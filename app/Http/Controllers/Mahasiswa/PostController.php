<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Post;
use App\Models\Mahasiswa\Like;
use App\Models\Mahasiswa\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // --- 1. INDEX (Menampilkan semua post) ---
    public function index()
    {
        $posts = Post::with('user', 'comments', 'likes')
            ->orderBy('tanggal_post', 'desc')
            ->get();

        return view('mahasiswa.posts.index', compact('posts'));
    }

    // --- 2. CREATE (Menampilkan formulir buat post) ---
    public function create()
    {
        return view('mahasiswa.posts.create');
    }

    // --- 3. STORE (Menyimpan post baru) ---
    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required',
            'gambar' => 'nullable|image|max:10240'
        ]);

        $post = new Post([
            'isi' => $request->isi,
            // Pastikan menggunakan $user->id (PK standar)
            'user_id' => Auth::id()
        ]);

        if ($request->hasFile('gambar')) {
            $post->gambar = $request->file('gambar')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('mahasiswa.posts.index')->with('success', 'Post berhasil dibuat!');
    }

    // --- 4. SHOW (Menampilkan detail post) ---
    public function show($id)
    {
        $post = Post::with('user', 'comments', 'likes')->findOrFail($id);
        return view('mahasiswa.posts.show', compact('post'));
    }

    // --- 5. EDIT (Menampilkan formulir edit) ---
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Otorisasi: Hanya pemilik yang boleh mengedit
        if ($post->user_id != Auth::id()) {
            return redirect()->route('mahasiswa.posts.index')->with('error', 'Tidak punya akses');
        }

        return view('mahasiswa.posts.edit', compact('post'));
    }

    // --- 6. UPDATE (Memperbarui post) ---
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Otorisasi
        if ($post->user_id != Auth::id()) {
            return redirect()->route('mahasiswa.posts.index')->with('error', 'Tidak punya akses');
        }

        $request->validate([
            'isi' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $post->isi = $request->isi;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($post->gambar) {
                Storage::disk('public')->delete($post->gambar);
            }

            $post->gambar = $request->file('gambar')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('mahasiswa.posts.index')->with('success', 'Post berhasil diperbarui!');
    }

    // --- 7. DESTROY (Menghapus post) ---
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Otorisasi
        if ($post->user_id != Auth::id()) {
            return redirect()->route('mahasiswa.posts.index')->with('error', 'Tidak punya akses');
        }

        // Hapus file gambar dari storage
        if ($post->gambar) {
            Storage::disk('public')->delete($post->gambar);
        }

        $post->delete();

        return redirect()->route('mahasiswa.posts.index')->with('success', 'Post berhasil dihapus!');
    }

    // --- 8. LIKE (Method Tambahan) ---
    public function like($post_id)
    {
        $user_id = Auth::id();

        $like = Like::where('post_id', $post_id)
                    ->where('user_id', $user_id)
                    ->first();

        if ($like) {
            $like->delete();
            $message = 'Unlike berhasil!';
        } else {
            Like::create([
                'post_id' => $post_id,
                'user_id' => $user_id,
            ]);
            $message = 'Like berhasil ditambahkan!';
        }

        return back()->with('success', $message);
    }

    // --- 9. SHARE (Method Tambahan) ---
    public function share(Request $request, $post_id)
    {
        $request->validate([
            'platform' => 'nullable|string|max:50',
        ]);

        Share::create([
            'post_id' => $post_id,
            'user_id' => Auth::id(),
            'platform' => $request->platform ?? 'Unknown',
        ]);

        return back()->with('success', 'Postingan berhasil dibagikan!');
    }
}
