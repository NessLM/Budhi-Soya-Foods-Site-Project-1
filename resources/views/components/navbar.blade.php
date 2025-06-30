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
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('product') }}" id="produkNav">Produk</a></li>
        <li><a href="{{ route('contact') }}">Kontak Kami</a></li>
        <li><a href="{{ route('aboutus') }}">Tentang Kami</a></li>
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

<!-- Login Modal (bisa dipanggil dari halaman manapun) -->
<div id="loginModal" class="login-modal" role="dialog" aria-labelledby="modal-title" aria-hidden="true" style="display:none;">
  <div class="modal-content">
    <button class="close-modal" aria-label="Close modal">&times;</button>
    <h3 id="modal-title">Login Diperlukan</h3>
    <p>Anda harus login terlebih dahulu untuk mengakses fitur ini.</p>
    <div class="modal-buttons">
      <a href="/login" class="modal-login-btn">
        <i class="fas fa-sign-in-alt"></i>
        Login
      </a>
      <a href="/register" class="modal-register-btn">
        <i class="fas fa-user-plus"></i>
        Daftar
      </a>
    </div>
  </div>
</div>

<link rel="stylesheet" href="/assets/css/component/navbar.css">
<script src="/assets/js/navbar.js"></script>

<script>
const loginRequiredButtons = [
    'pesanProdukBtn',
    'btnDetailProduk', 
    'lihatProdukBtn',
    'jelajahiBtn',
    'produkNav'
];

document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah user belum login (dengan bantuan blade)
    var isGuest = {{ Auth::check() ? 'false' : 'true' }};
    if(isGuest) {
        var produkNav = document.getElementById('produkNav');
        if(produkNav) {
            produkNav.addEventListener('click', function(e) {
                e.preventDefault();
                var loginModal = document.getElementById('loginModal');
                if(loginModal) loginModal.style.display = 'flex';
            });
        }
    }

    // Close modal
    var closeModal = document.querySelector('.close-modal');
    var loginModal = document.getElementById('loginModal');
    if(closeModal && loginModal) {
        closeModal.addEventListener('click', function() {
            loginModal.style.display = 'none';
        });
    }
    // Close modal on outside click
    if(loginModal) {
        loginModal.addEventListener('click', function(e) {
            if(e.target === loginModal) loginModal.style.display = 'none';
        });
    }
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && loginModal && loginModal.style.display === 'flex') {
            loginModal.style.display = 'none';
        }
    });
});
</script>

