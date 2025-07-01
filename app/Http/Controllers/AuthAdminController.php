<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LoginLog;

class AuthAdminController extends Controller
{
    public function showLoginAdmin()
    {
        return view('auth.login_admin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek login admin
        if (Auth::guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            // Catat login log
            LoginLog::create([
                'username' => $request->username,
                'role' => 'admin',
                'created_at' => now(),
            ]);

            // Sukses login, redirect ke dashboard admin
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Login admin berhasil!');
        }

        // Gagal login
        return back()->with('error', 'Username atau password admin salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda telah logout sebagai admin.');
    }

    
}