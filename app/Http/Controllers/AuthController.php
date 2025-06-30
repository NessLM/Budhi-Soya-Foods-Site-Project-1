<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('login', 'password');
        $loginInput = $credentials['login'];
        $password = $credentials['password'];
    
        // Tentukan field login: email atau username
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Gabungkan field login dan password ke dalam array credentials
        $loginData = [
            $field => $loginInput,
            'password' => $password
        ];
    
        // Coba login dengan Auth::attempt()
        if (Auth::attempt($loginData)) {
            $user = Auth::user();
            
            $request->session()->regenerate(); // cegah session fixation
            return redirect()->intended('/')->with('success', 'Selamat datang kembali, ' . $user->username . '!');
        }
    
        // Jika gagal login
        return back()->with('error', 'Username, email, atau password salah.')->withInput();
    }
    
    
    public function showRegister() {
        return view('auth.register');
    }

    /**
     * Fungsi registrasi baru yang disederhanakan.
     * User dibuat dan langsung login tanpa verifikasi email.
     */
    public function register(Request $request) {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Langsung login-kan user
        Auth::login($user);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->intended('/')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->username . '!');
    }

    public function logout(Request $request) {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Anda telah logout dengan aman.');
    }
    
}