<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/assets/css/admin-dashboard.css">
</head>
<body>
    <div class="dashboard-container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-container">
                <img src="/assets/img/logoforadmin.png" alt="Logo BSF" class="logo">
                <h3>BSF</h3>
            </div>

            <div class="section">
                <p class="section-title">Role</p>
                <ul class="nav-list">
                    <li>Admin</li>
                    <li>Pelanggan</li>
                </ul>
            </div>

            <div class="section">
                <p class="section-title">Manajemen Produk</p>
                <ul class="nav-list">
                    <li>Daftar Produk</li>
                    <li>Tambah Produk</li>
                    <li>Kategori</li>
                </ul>
            </div>

            <div class="section">
                <p class="section-title">Pengaturan Sistem</p>
                <ul class="nav-list">
                    <li>Pengguna</li>
                    <li>Log Aktivitas</li>
                    <li>Backup Data</li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <div class="welcome">
                    <h2>Welcome, {{ $admin->username }}</h2>
                    <p>Dashboard Admin</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </header>

            <section class="content-area">
                <!-- Konten utama dashboard bisa kamu isi di sini -->
            </section>
        </main>

    </div>
</body>
</html>
