<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // Pastikan kamu punya model Admin

class AuthAdminController extends Controller
{
public function showLoginAdmin() {
    return view('auth.login_admin');
}

public function loginAdmin(Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Anda berhasil datang, selamat datang ' . Auth::guard('admin')->user()->username);
    }

    return back()->with('error', 'Username atau password salah.');
}


public function logout()
{
    Auth::guard('admin')->logout();
    return redirect()->route('login.admin');
}

}
