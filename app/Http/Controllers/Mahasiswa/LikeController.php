<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Like;
use App\Models\Mahasiswa\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($post_id)
    {
        // Cek jika sudah like
        $existing = Like::where('post_id', $post_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($existing) {
            return back()->with('info', 'Anda sudah menyukai postingan ini.');
        }

        Like::create([
            'post_id' => $post_id,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', 'Berhasil menyukai postingan.');
    }

    public function destroy($post_id)
    {
        Like::where('post_id', $post_id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Berhasil batal menyukai.');
    }
}
