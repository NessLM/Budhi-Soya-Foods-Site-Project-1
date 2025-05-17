<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar">
    <!-- Logo -->
    <ul class="logoul">
        <li class="logo">
            <a href="/">
                <img src="/assets/img/logo.png" alt="Logo" class="logo-img" />
            </a>
        </li>
    </ul>


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
    </ul>

    <ul class="loginul">
        @auth
            <li class="profile-dropdown">
                <a href="#" class="profile-icon">👤</a>
                <div class="dropdown-content">
                    <a href="/pelanggan">Profile</a>
                    <a href="/pesanan">Pesanan Saya</a>
                    <a href="/logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @else
            <li class="login-btn"><a href="/login">Login</a></li>
        @endauth
    </ul>
    

</nav>

<link rel="stylesheet" href="/assets/css/component/navbar.css">