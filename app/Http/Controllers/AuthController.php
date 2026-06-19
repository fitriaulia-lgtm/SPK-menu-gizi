<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login admin
     */
    public function showLogin()
    {
        // Jika sudah login, langsung lempar ke portal/dashboard admin
        if (Auth::check()) {
            return redirect()->route('public.portal'); // Sementara balik ke depan atau panel admin Anda
        }
        return view('auth.login');
    }

    /**
     * Memproses data autentikasi login
     */
    public function login(Request $request)
    {
        // Validasi input form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Coba mencocokkan data login (fitur 'Remember Me' opsional)
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect ke halaman yang dituju atau default
            return redirect()->intended('/');
        }

        // Jika gagal, kembalikan dengan pesan error khusus
        return back()->withErrors([
            'login_error' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses fungsi keluar akun (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.portal');
    }
}