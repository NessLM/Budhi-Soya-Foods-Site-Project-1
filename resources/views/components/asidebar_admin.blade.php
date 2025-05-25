

<script src="https://unpkg.com/lucide@latest"></script>

<aside class="sidebar">
    <a href="/admin/dashboard" class="logo-container" title="Dashboard Admin">
        <img src="/assets/img/logoforadmin.png" alt="Logo BSF" class="logo">
        <h3>BSF</h3>
    </a>

    <div class="section">
        <p class="section-title">Role</p>
        <ul class="nav-list">
            <li>
                <a href="{{ route('rolemanagementadmin.index') }}">
                    <i data-lucide="shield-check"></i> Admin
                </a>
            </li>
            <li>
                <a href="#">
                    <i data-lucide="user"></i> Pelanggan
                </a>
            </li>
        </ul>
    </div>

    <div class="section">
        <p class="section-title">Manajemen Produk</p>
        <ul class="nav-list">
            <li>
                <a href="#">
                    <i data-lucide="list"></i> Daftar Produk
                </a>
            </li>
            <li>
                <a href="#">
                    <i data-lucide="plus-circle"></i> Tambah Produk
                </a>
            </li>
            <li>
                <a href="#">
                    <i data-lucide="tag"></i> Kategori
                </a>
            </li>
        </ul>
    </div>

    <div class="section">
        <p class="section-title">Pengaturan Sistem</p>
        <ul class="nav-list">
            <li>
                <a href="#">
                    <i data-lucide="users"></i> Pengguna
                </a>
            </li>
            <li>
                <a href="#">
                    <i data-lucide="activity"></i> Log Aktivitas
                </a>
            </li>
            <li>
                <a href="#">
                    <i data-lucide="database-backup"></i> Backup Data
                </a>
            </li>
        </ul>
    </div>
</aside>

<script>
    lucide.createIcons();
</script>


<link rel="stylesheet" href="/assets/css/component/admin/nav-admin.css">
