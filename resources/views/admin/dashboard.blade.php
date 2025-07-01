<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <x-admin.asidebar_admin></x-admin.asidebar_admin>
    <div class="dashboard-container">
        
        <!-- Main Content -->
<main class="main-content">
    <x-admin.atopbar_admin title="Dashboard Admin" icon="fas fa-user-shield" />


    <section class="content-area">
        <div class="stat-grid">
            <div class="stat-card">
                <i class="fas fa-user-cog stat-icon"></i>
                <h3>Jumlah Admin</h3>
                <p>{{ $adminCount }}</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-users stat-icon"></i>
                <h3>Jumlah Pengguna</h3>
                <p>{{ $userCount }}</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-box-open stat-icon"></i>
                <h3>Jumlah Produk</h3>
                <p>{{ $productCount }}</p>
            </div>
        </div>

        <!-- Pendapatan dan Riwayat -->
        <div class="pendapatan-riwayat-grid">
            <div class="pendapatan-card">
                <i class="fas fa-coins pendapatan-icon"></i>
                <h3>Pendapatan Bulanan</h3>
                <p>Rp 0,-</p>
            </div>
            <div class="pendapatan-card">
                <i class="fas fa-wallet pendapatan-icon"></i>
                <h3>Pendapatan Tahunan</h3>
                <p>Rp 0,-</p>
            </div>
            <div class="riwayat-card">
                <h3><i class="fas fa-history"></i> Riwayat Login Admin</h3>
                <ul>
                    @forelse($riwayat as $log)
                        <li><i class="fas fa-user"></i> {{ $log->username }} - {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</li>
                    @empty
                        <li><i class="fas fa-info-circle"></i> Belum ada riwayat login</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Grafik Placeholder -->
        <div class="grafik-container">
            <div class="grafik-card" id="grafik-penjualan">
                <h3><i class="fas fa-chart-line"></i> Grafik Penjualan Bulanan</h3>
                <!-- Chart.js nanti di sini -->
            </div>
            <div class="grafik-card" id="grafik-pengguna">
                <h3><i class="fas fa-chart-pie"></i> Grafik Pertumbuhan Pengguna</h3>
                <!-- Chart.js nanti di sini -->
            </div>
        </div>
    </section>
</main>


    </div>
</body>
</html>
