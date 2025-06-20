<!-- resources/views/components/navbar.blade.php -->
<nav class="navbar">
    <!-- Toggle Button (Mobile only) -->
    <button class="menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle navigation menu">&#9776;</button>

    <!-- Logo -->
    <ul class="logoul">
        <li class="logo">
            <a href="/" aria-label="Budhi Soya Foods - Home">
                <img src="/assets/img/logo.png" alt="Budhi Soya Foods Logo" class="logo-img" />
            </a>
        </li>
    </ul>

    <!-- Nav links -->
    <ul class="nav-links">
        <li><a href="/">Beranda</a></li>
        <li>
            @auth
            <a href="/product">Produk</a>
            @else
            <a href="/product" id="produkNav">Produk</a>
            @endauth
        </li>
        <li><a href="/contact">Kontak Kami</a></li>
        <li><a href="/aboutus">Tentang Kami</a></li>
        @auth
            <li><a href="{{ route('cart.index') }}" class="nav-link cart-link">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-counter" id="cartCounter" style="display: none;">0</span>
            </a></li>
        @endauth

        @auth
            <li><a href="/profile" class="username-link">
                <i class="fas fa-user"></i>
                {{ strtoupper(Auth::user()->username) }}
            </a></li>
        @endauth
    </ul>

    <!-- Login / Account -->
    <ul class="btnaccount">
        @auth
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        @else
            <li class="login-btn"><a href="/login">Masuk</a></li>
            <li class="register-btn"><a href="/register">Daftar</a></li>
        @endauth
    </ul>
</nav>

<link rel="stylesheet" href="/assets/css/component/navbar.css">
<script src="/assets/js/navbar.js"></script>