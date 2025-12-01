<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Like;
use App\Models\Mahasiswa\Post;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LikeNotification;

class LikeController extends Controller
{
    /**
     * Menyukai post
     */
    public function store($post_id)
    {
        // Ambil post
        $post = Post::findOrFail($post_id);

        // Cek apakah sudah like
        $existing = Like::where('post_id', $post_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($existing) {
            return back()->with('info', 'Anda sudah menyukai postingan ini.');
        }

        // Simpan like
        Like::create([
            'post_id' => $post_id,
            'user_id' => Auth::id()
        ]);

        // Kirim notifikasi ke pemilik post
        // Hanya jika post bukan milik sendiri
        if ($post->user && $post->user->id != Auth::id()) {
            $post->user->notify(new LikeNotification($post, Auth::user()));
        }

        return back()->with('success', 'Berhasil menyukai postingan.');
    }

    /**
     * Batalkan like
     */
    public function destroy($post_id)
    {
        Like::where('post_id', $post_id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Berhasil batal menyukai.');
    }
}
