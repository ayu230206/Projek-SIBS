<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bpdpks\Kampus; // Pastikan namespace ini sesuai dengan Model Kampus Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    // --- FITUR UTAMA: LIST USER & CRUD STANDARD (Admin/BPDPKS) ---

    public function index(Request $request)
    {
        $query = User::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', $search)
                  ->orWhere('email', 'like', $search);
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Form Standard (Biasanya untuk buat Admin/BPDPKS baru).
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store Standard (Admin menginput email & password secara manual).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'role'         => ['required', Rule::in(['admin', 'bpdpks'])],
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User Admin/BPDPKS berhasil ditambahkan.');
    }

    // --- FITUR KHUSUS: AUTO-GENERATE MAHASISWA ---

    /**
     * Menampilkan form khusus tambah mahasiswa (Input Nama & Kampus saja).
     */
    public function createMahasiswa()
    {
        // Mengambil data kampus untuk dropdown
        $kampus = Kampus::where('status_kerjasama', 'aktif')->orderBy('nama_kampus')->get();
        
        return view('admin.users.create_mahasiswa', compact('kampus'));
    }

    /**
     * Proses Logic Looping Email & Auto Password.
     */
    public function storeMahasiswa(Request $request)
    {
        // 1. Validasi: Admin TIDAK input email/password di sini
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'asal_kampus'  => 'required|exists:kampus,id',
            'angkatan'     => 'required|numeric',
        ]);

        // 2. Logic Generate Email
        $namaParts = explode(' ', trim($request->nama_lengkap));
        $namaDepan = strtolower($namaParts[0]);
        // Bersihkan karakter aneh
        $namaDepan = preg_replace('/[^a-z0-9]/', '', $namaDepan);
        
        $domain = 'mahasiswa.sawit.ac.id';
        $baseEmail = $namaDepan . '@' . $domain;
        $finalEmail = $baseEmail;
        
        $counter = 1;
        // Cek database user untuk hindari duplikasi
        while (User::where('email', $finalEmail)->exists()) {
            $finalEmail = $namaDepan . $counter . '@' . $domain;
            $counter++;
        }

        // 3. Logic Generate Password (Random 8 Karakter)
        $generatedPassword = Str::random(8); 

        // 4. Simpan ke Database
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $finalEmail,
            'password'     => Hash::make($generatedPassword),
            'role'         => 'mahasiswa',
            'asal_kampus'  => $request->asal_kampus,
            'angkatan'     => $request->angkatan,
            'status_aktif' => true,
        ]);

        // 5. Siapkan data credential untuk ditampilkan
        $credentials = [
            'name' => $request->nama_lengkap,
            'email' => $finalEmail,
            'password' => $generatedPassword
        ];

        // 6. Redirect dengan flash message
        return redirect()->route('admin.users.index')
            ->with('credentials', $credentials)
            ->with('success', 'Akun Mahasiswa berhasil dibuat otomatis!');
    }

    // --- FITUR UMUM: EDIT & DELETE ---

    public function edit(User $user)
    {
        // Perlu data kampus jika user yang diedit adalah mahasiswa
        $kampus = Kampus::orderBy('nama_kampus')->get(); 
        return view('admin.users.edit', compact('user', 'kampus'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,'.$user->id,
            'role'         => ['required', Rule::in(['admin', 'bpdpks', 'mahasiswa'])],
            'asal_kampus'  => 'nullable|required_if:role,mahasiswa|exists:kampus,id',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'role'         => $request->role,
            'asal_kampus'  => $request->asal_kampus,
        ];

        // Jika password diisi, update. Jika kosong, biarkan password lama.
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}