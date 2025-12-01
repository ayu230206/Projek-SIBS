<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification; // ✅ WAJIB
use App\Notifications\NotifUmum; // ✅ WAJIB

class MagangController extends Controller
{
    public function index()
    {
        $magangs = Magang::where('user_id', Auth::id())->get();
        return view('mahasiswa.magang.index', compact('magangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tempat_magang' => 'required',
            'posisi' => 'required',
            'file_pendukung' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $data = $request->only(['tempat_magang', 'posisi', 'deskripsi', 'mulai', 'selesai']);

        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('magang/file', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['status_pengajuan'] = 'pending';
        $data['tanggal_pengajuan'] = now();

        $magang = Magang::create($data);

        // ✅ ✅ ✅ NOTIFIKASI TANPA notify()
        $user = Auth::user();
        Notification::send($user, new NotifUmum(
            'Pengajuan Magang',
            'Pengajuan magang kamu berhasil dikirim',
            url('/notifikasi')
        ));

        return back()->with('success', 'Pengajuan magang berhasil');
    }

    public function update(Request $request, $id)
    {
        $magang = Magang::where('magang_id', $id)->firstOrFail();

        if ($magang->user_id != Auth::id() || $magang->status_pengajuan != 'pending') {
            return back();
        }

        $request->validate([
            'tempat_magang' => 'required',
            'posisi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_pendukung' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('magang/gambar', 'public');
        }

        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')->store('magang/file', 'public');
        }

        $magang->update($data);

        // ✅ ✅ ✅ NOTIFIKASI TANPA notify()
        $user = Auth::user();
        Notification::send($user, new NotifUmum(
            'Update Pengajuan Magang',
            'Data pengajuan magang kamu diperbarui',
            url('/notifikasi')
        ));

        return back()->with('success', 'Magang diperbarui');
    }

    public function destroy($id)
    {
        $magang = Magang::where('magang_id', $id)->firstOrFail();

        if ($magang->user_id != Auth::id() || $magang->status_pengajuan != 'pending') {
            return back();
        }

        $magang->delete();

        // ✅ ✅ ✅ NOTIFIKASI TANPA notify()
        $user = Auth::user();
        Notification::send($user, new NotifUmum(
            'Pengajuan Magang Dihapus',
            'Pengajuan magang kamu dihapus',
            url('/notifikasi')
        ));

        return back()->with('success', 'Magang dihapus');
    }
}
