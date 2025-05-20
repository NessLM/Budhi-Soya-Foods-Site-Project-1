<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RoleManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::all();

        return view('admin.manage_admins.manage_admin', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:admins,username',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => $request->password, // auto hashed karena casts di model Admin
        ]);

        return redirect()->route('role.manageadmin.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function update(Request $request, Admin $admin)
    {
        if ($admin->id === auth()->guard('admin')->id()) {
            return redirect()->route('role.manageadmin.index')->with('error', 'Tidak bisa mengubah admin yang sedang aktif.');
        }

        $request->validate([
            'username' => ['required', 'string', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:6',
        ]);

        $admin->username = $request->username;
        if ($request->filled('password')) {
            $admin->password = $request->password; // auto hashed
        }
        $admin->save();

        return redirect()->route('role.manageadmin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->guard('admin')->id()) {
            return redirect()->route('role.manageadmin.index')->with('error', 'Tidak bisa menghapus admin yang sedang aktif.');
        }

        $admin->delete();

        return redirect()->route('role.manageadmin.index')->with('success', 'Admin berhasil dihapus.');
    }
}
