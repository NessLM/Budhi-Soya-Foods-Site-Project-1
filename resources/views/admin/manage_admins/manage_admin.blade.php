<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Manajemen Admin</title>
    <link rel="stylesheet" href="/assets/css/admin-dashboard.css" />
    <link rel="stylesheet" href="/assets/css/component/admin/admin-management.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>

    <x-admin.asidebar_admin></x-admin.asidebar_admin>

    <div class="dashboard-container">
        <main class="main-content">
            <x-admin.atopbar-admin title="Manajemen Admin" icon="fas fa-user-cog" />

            <section class="content-area">
                <button id="btnAddAdmin" class="btn btn-green" style="margin-bottom: 1rem;">
                    <i class="fas fa-user-plus"></i> Tambah Admin
                </button>

                <!-- Form Tambah Admin -->
                <section id="addAdminSection" class="form-section d-none">
                    <h3>Tambah Admin Baru</h3>

                    <form method="POST" action="{{ route('rolemanagementadmin.store') }}" id="addAdminForm">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" type="text" required minlength="4" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="password-wrapper">
                                <input name="password" type="password" minlength="6" />
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-green">Simpan</button>
                        <button type="button" id="btnCancelAdd" class="btn btn-gray">Batal</button>
                    </form>
                </section>

                <!-- Wrapper dua kolom: tabel admin + audit log -->
                <div class="admin-management-wrapper">
                    <!-- Tabel Admin -->
                    <section class="admin-table-section">
                        <table
                            class="admin-table"
                            border="1"
                            cellpadding="8"
                            cellspacing="0"
                            style="width: 100%; border-collapse: collapse;"
                        >
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
                                        <div class="action-buttons">
                                            <button class="btn btn-edit btn-green" data-id="{{ $admin->id }}">Edit</button>
                                            <form
                                                method="POST"
                                                action="{{ route('rolemanagementadmin.destroy', $admin->id) }}"
                                                class="delete-form"
                                                onsubmit="return confirm('Yakin ingin menghapus admin ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete btn-red">Hapus</button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Form Edit -->
                                <tr class="edit-form-row d-none" id="editFormRow-{{ $admin->id }}">
                                    <td colspan="4">
                                        <form
                                            method="POST"
                                            action="{{ route('rolemanagementadmin.update', $admin->id) }}"
                                            data-id="{{ $admin->id }}"
                                            class="edit-admin-form"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group-inline" style="display:flex; gap:1rem; align-items:center;">
                                                <label>Username</label>
                                                <input
                                                    name="username"
                                                    type="text"
                                                    value="{{ $admin->username }}"
                                                    required
                                                    minlength="4"
                                                />
                                                <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                                                <div class="password-wrapper">
                                                    <input name="password" type="password" />
                                                    <i class="fas fa-eye toggle-password"></i>
                                                </div>

                                                <button type="submit" class="btn btn-green">Update</button>
                                                <button
                                                    type="button"
                                                    class="btn btn-gray btn-cancel-edit"
                                                    data-id="{{ $admin->id }}"
                                                >
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>

                    <!-- Audit Log -->
                    <aside class="audit-log">
                        <h3>Audit Log</h3>
                        <ul id="auditLogList">
                            <!-- Data audit log dinamis disini -->
                            @foreach($auditLogs as $log)
                            <li>
                                <strong>{{ $log->admin_username }}</strong> {{ $log->action }} <strong>{{ $log->target_username }}</strong><br />
<time>{{ $log->created_at->format('d M Y H:i:s') }}</time>

                            </li>
                            @endforeach
                        </ul>
                    </aside>
                </div>
            </section>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="/assets/js/admin-management.js"></script>
</body>

</html>
