<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Admin</title>
    <link rel="stylesheet" href="/assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="/assets/css/component/admin/admin-management.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

    <x-asidebar_admin></x-asidebar_admin>

    <div class="dashboard-container">
        <main class="main-content">
            <header class="topbar">
                <div class="welcome">
                    <h2><i class="fas fa-user-cog"></i> Manajemen Admin</h2>
                    <p>Login sebagai <strong>{{ auth('admin')->user()->username }}</strong></p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </header>

            <section class="content-area">
                <button id="btnAddAdmin" class="btn btn-green" style="margin-bottom: 1rem;">
                    <i class="fas fa-user-plus"></i> Tambah Admin
                </button>

                <!-- Form Tambah Admin -->
                <section id="addAdminSection" class="form-section d-none">
                    <h3>Tambah Admin Baru</h3>
                    <form method="POST" action="{{ route('rolemanagementadmin.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" required>
                        </div>
                        <button type="submit" class="btn btn-green">Simpan</button>
                        <button type="button" id="btnCancelAdd" class="btn btn-gray">Batal</button>
                    </form>
                </section>

                <!-- Tabel Admin -->
                <section class="admin-table-section">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr data-id="{{ $admin->id }}">
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->username }}</td>
                                <td>
                                    @if($admin->id === auth('admin')->user()->id)
                                        <span class="status-active">Active Right Now</span>
                                    @else
                                        <span class="status-inactive">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->id === auth('admin')->user()->id)
                                        <span class="btn-disabled">Active Right Now</span>
                                    @else
                                        <button class="btn btn-edit btn-green" data-id="{{ $admin->id }}">Edit</button>
                                        <form method="POST" action="{{ route('rolemanagementadmin.destroy', $admin->id) }}" class="delete-form d-inline" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete btn-red">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            <!-- Form Edit -->
                            <tr class="edit-form-row d-none" id="editFormRow-{{ $admin->id }}">
                                <td colspan="4">
                                    <form method="POST" action="{{ route('rolemanagementadmin.update', $admin->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group-inline">
                                            <label>Username</label>
                                            <input name="username" type="text" value="{{ $admin->username }}" required>
                                            <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                                            <input name="password" type="password">
                                            <button type="submit" class="btn btn-green">Update</button>
                                            <button type="button" class="btn btn-gray btn-cancel-edit" data-id="{{ $admin->id }}">Batal</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </section>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="/assets/js/admin-management.js"></script>
</body>
</html>