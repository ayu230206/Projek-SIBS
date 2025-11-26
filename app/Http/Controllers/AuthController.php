<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kampus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        $kampus = Kampus::all();
        return view('auth.register', compact('kampus'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'asal_kampus'  => 'required|exists:kampus,id',
            'angkatan'     => 'required|numeric'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'mahasiswa',
            'asal_kampus'  => $request->asal_kampus,
            'angkatan'     => $request->angkatan,
            'status_aktif' => true
        ]);

        return redirect()->route('login')->with('status', 'Registrasi berhasil, silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            switch ($role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'bpdpks':
                    return redirect()->intended('/bpdpks/dashboard');
                case 'mahasiswa':
                    return redirect()->intended('/dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Role akun tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('status', 'Berhasil logout.');
    }
}