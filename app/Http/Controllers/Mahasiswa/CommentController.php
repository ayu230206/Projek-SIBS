<?php

// app/Http/Controllers/Mahasiswa/CommentController.php

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $post_id,
            'user_id' => Auth::id(),
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        // Otorisasi: Hanya pemilik komentar atau admin yang boleh menghapus
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $comment->delete();
        
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}