<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthAdminController extends Controller
{
    public function showLoginAdmin()
    {
        // Kalau udah login, langsung lempar ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login_admin');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate(); // untuk menghindari session fixation attack

            // Catat login ke log
            DB::table('login_logs')->insert([
                'username' => $request->username,
                'role' => 'admin',
                'created_at' => now(),
            ]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::guard('admin')->user()->username);
        }

        return back()->withInput()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate(); // hapus semua session
        $request->session()->regenerateToken(); // amankan CSRF token baru

        return redirect()->route('login.admin')->with('success', 'Anda telah logout dengan aman.');
    }
}
