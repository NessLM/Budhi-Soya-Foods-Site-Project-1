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
            $request->session()->regenerate(); // cegah session fixation
            return redirect()->intended('/');
        }
    
        // Jika gagal login
        return back()->with('error', 'Username, email, atau password salah.')->withInput();
    }
    
    
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    
        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }
    

    public function logout(Request $request) {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    
}
