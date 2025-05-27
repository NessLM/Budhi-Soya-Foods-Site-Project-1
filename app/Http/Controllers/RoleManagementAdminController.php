<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AuditLogAdmin;
use Illuminate\Support\Facades\Hash;

class RoleManagementAdminController extends Controller
{
    // Tampilkan halaman manajemen admin
    public function index()
    {
        $admins = Admin::all();
        $auditLogs = AuditLogAdmin::with('admin')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($log) {
        return (object)[
            'admin_username' => $log->admin->username ?? 'Unknown',
            'action' => $log->action,
            'target_username' => $log->target_username,  // <- ini tambahan
            'created_at' => $log->created_at,
        ];
    });


        return view('admin.manage_admins.manage_admin', compact('admins', 'auditLogs'));
    }

    // Simpan admin baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        // Catat log audit
        AuditLogAdmin::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Menambahkan admin baru',
            'target_username' => $admin->username,
            'description' => 'Admin ' . auth('admin')->user()->username . ' menambahkan admin ' . $admin->username,
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    // Update data admin
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah akun yang sedang login.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'password' => 'nullable|string|min:6',
        ]);

        $oldUsername = $admin->username;

        $admin->username = $validated['username'];
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();

        AuditLogAdmin::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Memperbarui admin',
            'target_username' => $oldUsername,
            'description' => 'Admin ' . auth('admin')->user()->username . ' memperbarui admin ' . $oldUsername,
        ]);

        return redirect()->back()->with('success', 'Admin berhasil diperbarui.');
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun yang sedang login.');
        }

        $deletedUsername = $admin->username;
        $admin->delete();

        AuditLogAdmin::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Menghapus admin',
            'target_username' => $deletedUsername,
            'description' => 'Admin ' . auth('admin')->user()->username . ' menghapus admin ' . $deletedUsername,
        ]);

        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }
}
