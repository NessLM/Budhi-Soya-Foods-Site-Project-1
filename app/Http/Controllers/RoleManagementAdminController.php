<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class RoleManagementAdminController extends Controller
{
    // Tampilkan halaman manajemen admin
    public function index()
    {
        $admins = Admin::all();
        return view('admin.manage_admins.manage_admin', compact('admins'));
    }

    // Simpan admin baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    // Update data admin
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Cegah perubahan terhadap admin yang sedang login
        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah akun yang sedang login.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'password' => 'nullable|string|min:6',
        ]);

        $admin->username = $validated['username'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->back()->with('success', 'Admin berhasil diperbarui.');
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        // Cegah penghapusan admin yang sedang login
        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun yang sedang login.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }
}
