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
    
        // Cek apakah user dengan email/username tersebut ada
        $user = \App\Models\User::where($field, $loginInput)->first();
    
        if (!$user) {
            return back()->with('error', 'Username atau email Anda tidak ditemukan.')->withInput();
        }
    
        // Cek apakah password cocok
        if (!Hash::check($password, $user->password)) {
            return back()->with('error', 'Password Anda salah.')->withInput();
        }
    
        // Login berhasil
        Auth::login($user);
        return redirect('/');
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

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
