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
                <a href="/admin/role-management">
                    <i data-lucide="shield-check"></i> Admin
                </a>
            </li>
            <li>
                <a href="/admin/user-management">
                    <i data-lucide="user"></i> User
                </a>
            </li>
        </ul>
    </div>

    <div class="section">
        <p class="section-title">Manajemen Produk</p>
        <ul class="nav-list">
            <li>
                <a href="/admin/daftarproduk">
                    <i data-lucide="list"></i> Daftar Produk
                </a>
            </li>
            <li>
                <a href="/admin/tambahproduk">
                    <i data-lucide="plus-circle"></i> Tambah Produk
                </a>
            </li>
        </ul>
    </div>

    <div class="section">
        <p class="section-title">Penjualan</p>
        <ul class="nav-list">
            <li>
                <a href="/admin/pesanan">
                    <i data-lucide="shopping-cart"></i> Pesanan
                </a>
            </li>
            <li>
                <a href="/admin/pendapatan">
                    <i data-lucide="dollar-sign"></i> Pendapatan
                </a>
            </li>
        </ul>
    </div>

    <div class="section">
        <p class="section-title">Pengaturan Sistem</p>
        <ul class="nav-list">
            <li>
                <a href="/admin/log-aktivitas">
                    <i data-lucide="activity"></i> Log Aktivitas
                </a>
            </li>
            <li>
                <a href="/admin/backup-data">
                    <i data-lucide="database-backup"></i> Backup & Restore
                </a>
            </li>
            <li>
                <a href="/admin/pengaturan-umum">
                    <i data-lucide="settings"></i> Pengaturan Umum
                </a>
            </li>
        </ul>
    </div>
</aside>

<script>
    lucide.createIcons();
</script>

<link rel="stylesheet" href="/assets/css/component/admin/nav-admin.css">
