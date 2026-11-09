<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan form login admin
     */
    public function showLogin()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
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
            'role' => ['required', 'in:admin,petugas'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'role.required' => 'Peran wajib dipilih.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        // Coba mencocokkan data login (fitur 'Remember Me' opsional)
        $remember = $request->has('remember');

        // Tambahkan role ke dalam credentials untuk validasi
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect ke dashboard setelah login berhasil
            return redirect()->route('admin.dashboard');
        }

        // Jika gagal, kembalikan dengan pesan error khusus
        return back()->withErrors([
            'login_error' => 'Email, password, atau peran yang Anda masukkan salah.',
        ])->onlyInput('email', 'role');
    }

    /**
     * Menampilkan form registrasi admin/petugas
     */
    public function showRegister()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.register');
    }

    /**
     * Memproses data registrasi pengguna baru
     */
    public function register(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // role optional, default 'petugas'
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $request->input('role', 'petugas'), // default petugas
        ]);

        // Arahkan ke halaman login untuk melakukan login manual
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login dengan email dan password Anda.');
    }

    /**
     * Admin: buat pengguna baru tanpa melakukan auto-login.
     */
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'in:admin,petugas'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $request->input('role', 'petugas'),
        ]);

        return back()->with('success', 'Pengguna baru berhasil dibuat.');
    }

    /**
     * Tampilkan form edit profil untuk admin.
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Proses update profil admin (nama, email, password).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Memproses fungsi keluar akun (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}