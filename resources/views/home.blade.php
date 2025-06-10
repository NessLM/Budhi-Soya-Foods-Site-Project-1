<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Budhi Soya Foods</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/home.css" />
  <script src="/assets/js/home.js"></script>
</head>

<body class="font-sans bg-white">
  <x-navbar></x-navbar>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-section-item">
      <div class="hero-section-content">
        <h1>Soya Foods</h1>
        <p>Bergizi, organik, dan dibuat secara lokal dengan penuh cinta. Mulailah gaya hidup sehatmu bersama kami</p>
        @auth
          <button onclick="window.location.href='/products'">Pesan Produk</button>
        @else
          <button id="pesanProdukBtn">Pesan Produk</button>
        @endauth
      </div>
      <div class="hero-image"></div>
    </div>
  </section>

  <!-- Body Section -->
  <section class="body-section">
    <h2>
      Kami Menyediakan
      <span></span>
    </h2>

    <!-- Product Section -->
    <div class="product-section">
      <div class="product-slider">
        @if($products->isNotEmpty())
          <nav class="arrow-direction-left"><i class="fas fa-chevron-left"></i></nav>
          
          <div class="img-product">
            <img id="product-image" src="{{ asset('uploads/products/' . $products->first()->foto) }}" alt="{{ $products->first()->nama_produk }}">
          </div>

          <div class="descript-product">
            <h3 id="product-title">{{ $products->first()->nama_produk }}</h3>
            <p class="product-desc" id="product-desc">{{ Str::limit($products->first()->deskripsi, 120) }}</p>
            <div class="product-details" id="product-details">
              <span>Harga: Rp{{ number_format($products->first()->harga, 0, ',', '.') }}</span>
              <span>Stok: {{ $products->first()->jumlah_produk }}</span>
            </div>

            @auth
              <a href="/product">
                <button class="btn-detail">Detail Produk</button>
              </a>
            @else
            <a href="/product">
              <button class="btn-detail" id="btnDetailProduk">Detail Produk</button>
            </a>
            @endauth

            <div class="dots-navigation">
              @foreach ($products as $index => $product)
                <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
              @endforeach
            </div>
          </div>

          <nav class="arrow-direction-right"><i class="fas fa-chevron-right"></i></nav>
        @else
          <div class="no-products">
            <p>Tidak ada produk tersedia saat ini.</p>
          </div>
        @endif
      </div>
    </div>
  </section>

  <!-- Choice Section -->
  <section class="choice-section">
    <div class="container mx-auto px-4">
      <h2>Mengapa Memilih Kami?<span></span></h2>
      
      <div class="choice-cards">
        <div class="choice-card choice-card-red">
          <div class="choice-icon">🥛</div>
          <h3>100%</h3>
          <p>Produk Organik Asli</p>
        </div>
        
        <div class="choice-card choice-card-yellow">
          <div class="choice-icon">🏆</div>
          <h3>Bahan Berkualitas</h3>
          <p>Terbaik</p>
        </div>
        
        <div class="choice-card choice-card-green">
          <div class="choice-icon">😊</div>
          <h3>Chutt enak UNTUK Lokal</h3>
          <p>Rasa yang autentik</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Recommendation -->
  <section class="recommendation-section">
    <div class="container mx-auto px-4">
      <div class="recommendation-grid">
        <div class="recommendation-content">
          <p class="recommendation-subtitle">Silakan produk kami</p>
          <h2>PRODUK REKOMENDASI</h2>
          <p class="recommendation-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
          @auth
            <button onclick="window.location.href='/products'" class="recommendation-btn">Lihat Produk</button>
          @else
            <button id="lihatProdukBtn" class="recommendation-btn">Lihat Produk</button>
          @endauth
        </div>
        <div class="recommendation-image">
          <div class="recommendation-placeholder"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Popular Product -->
  <section class="popular-section">
    <div class="container mx-auto px-4">
      <div class="popular-grid">
        <div class="popular-image">
          <div class="popular-placeholder"></div>
        </div>
        <div class="popular-content">
          <p class="popular-subtitle">Temukan produk kami</p>
          <h2>TEMUKAN YANG PAS BUAT KAMU!</h2>
          <p class="popular-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          @auth
            <button onclick="window.location.href='/products'" class="popular-btn">Jelajahi</button>
          @else
            <button id="jelajahiBtn" class="popular-btn">Jelajahi</button>
          @endauth
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services-section">
    <div class="container mx-auto px-4">
      <h2>Melayani Acara Seperti...<span></span></h2>
      
      <div class="services-grid">
        <div class="services-list">
          <ul>
            <li><i class="fas fa-check"></i> Pernikahan</li>
            <li><i class="fas fa-check"></i> Aqiqah</li>
            <li><i class="fas fa-check"></i> Khitanan</li>
            <li><i class="fas fa-check"></i> Kegiatan Masjid</li>
            <li><i class="fas fa-check"></i> Dll</li>
          </ul>
        </div>
        
        <div class="services-gallery">
          <div class="service-img"></div>
          <div class="service-img"></div>
          <div class="service-img"></div>
          <div class="service-img"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section class="map-section">
    <div class="container mx-auto px-4">
      <h2>Lokasi Kami<span></span></h2>
      <div class="map-container">
        <div class="map-placeholder">
          <i class="fas fa-map-marker-alt"></i>
          <p>Google Maps akan ditampilkan di sini</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="container mx-auto px-4">
      <div class="footer-grid">
        <div class="footer-col">
          <h3>Budhi Soya Foods</h3>
          <p>Menyediakan produk soya berkualitas tinggi untuk gaya hidup sehat Anda.</p>
        </div>
        
        <div class="footer-col">
          <h4>Produk</h4>
          <ul>
            <li><a href="#">Tempe</a></li>
            <li><a href="#">Tahu</a></li>
            <li><a href="#">Susu Kedelai</a></li>
          </ul>
        </div>
        
        <div class="footer-col">
          <h4>Layanan</h4>
          <ul>
            <li><a href="#">Catering</a></li>
            <li><a href="#">Pesanan Khusus</a></li>
            <li><a href="#">Konsultasi</a></li>
          </ul>
        </div>
        
        <div class="footer-col">
          <h4>Kontak</h4>
          <div class="footer-contact">
            <p><i class="fas fa-phone"></i> +62 123 456 789</p>
            <p><i class="fas fa-envelope"></i> info@budhisoya.com</p>
            <p><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</p>
          </div>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; 2024 Budhi Soya Foods. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Login Modal -->
<div id="loginModal" class="login-modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <h3>Login Required</h3>
    <p>Anda harus login terlebih dahulu untuk mengakses fitur ini.</p>
    <div class="modal-buttons">
      <a href="/login" class="modal-login-btn">Login</a>
      <a href="/register" class="modal-register-btn">Register</a>
    </div>
  </div>
</div>

  <script>
    // Pass products data to JavaScript
    const products = @json($products);
  </script>

</body>
</html>