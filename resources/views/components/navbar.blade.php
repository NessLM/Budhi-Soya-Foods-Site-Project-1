<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar">
    <!-- Toggle Button (Mobile only) -->
    <button class="menu-toggle" onclick="document.querySelector('.navbar').classList.toggle('active')">&#9776;</button>

    <!-- Logo -->
    <ul class="logoul">
        <li class="logo">
            <a href="/">
                <img src="/assets/img/logo.png" alt="Logo" class="logo-img" />
            </a>
        </li>
    </ul>

    <!-- Nav links -->
    <ul class="nav-links">
        <li><a href="/">Beranda</a></li>
        <li class="dropdown">
            <a href="/product" class="dropbtn">Produk</a>
            <div class="dropdown-content">
                <a href="/Product/kategori1">Kategori 1</a>
                <a href="/Product/kategori2">Kategori 2</a>
                <a href="/Product/kategori3">Kategori 3</a>
            </div>
        </li>
        <li><a href="/contact">Kontak Kami</a></li>
        <li><a href="/aboutus">Tentang Kami</a></li>

        @auth
            <li><a href="#">{{ strtoupper(Auth::user()->username) }}</a></li>
        @endauth
    </ul>

    <!-- Login / Profile -->
    <ul class="btnaccount">
        @auth
            <li class="profile-dropdown">
                <a href="#" class="profile-icon">👤</a>
                <div class="dropdown-content">
                    <a href="/pelanggan">Profile</a>
                    <a href="/pesanan">Pesanan Saya</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </li>
        @else
            <li class="login-btn"><a href="/login">Masuk</a></li>
            <li class="register-btn"><a href="/register">Daftar</a></li>
        @endauth
    </ul>
</nav>

<link rel="stylesheet" href="/assets/css/component/navbar.css">
<script src="/assets/js/navbar.js"></script>