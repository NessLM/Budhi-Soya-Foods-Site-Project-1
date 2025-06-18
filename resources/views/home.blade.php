
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Budhi Soya Foods - Produk Soya Berkualitas</title>
  <meta name="description" content="Budhi Soya Foods menyediakan produk soya berkualitas tinggi, organik, dan bergizi untuk gaya hidup sehat Anda.">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/home.css" />
  <script src="/assets/js/home.js" defer></script>
</head>

<body class="font-sans bg-white">
  <x-navbar></x-navbar>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-section-item">
      <div class="hero-section-content">
        <h1>Budhi Soya Foods</h1>
        <p>Bergizi, organik, dan dibuat secara lokal dengan penuh cinta. Mulailah gaya hidup sehatmu bersama produk soya berkualitas tinggi kami.</p>
        @auth
          <button onclick="window.location.href='/product'" class="hero-btn">
            <i class="fas fa-shopping-cart"></i>
            Pesan Produk Sekarang
          </button>
        @else
          <button id="pesanProdukBtn" class="hero-btn">
            <i class="fas fa-shopping-cart"></i>
            Pesan Produk Sekarang
          </button>
        @endauth
      </div>
      <div class="hero-image">
        <div class="hero-overlay"></div>
      </div>
    </div>
  </section>

  <!-- Body Section -->
  <section class="body-section">
    <div class="container">
      <h2 class="section-title">
        Kami Menyediakan
        <span class="title-underline"></span>
      </h2>

      <!-- Product Section -->
      <div class="product-section">
        <div class="product-slider">
          @if($products->isNotEmpty())
            <button class="arrow-direction-left" aria-label="Previous product">
              <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="img-product">
              <div class="product-image-container">
                <img id="product-image" 
                     src="{{ asset('uploads/products/' . $products->first()->foto) }}" 
                     alt="{{ $products->first()->nama_produk }}"
                     loading="lazy">
                <div class="product-badge">
                  <i class="fas fa-leaf"></i>
                  {{ $products->first()->kategori }}
                </div>
              </div>
            </div>

            <div class="descript-product">
              <div class="product-category">{{ $products->first()->kategori }}</div>
              <h3 id="product-title">{{ $products->first()->nama_produk }}</h3>
              <p class="product-desc" id="product-desc">{{ Str::limit($products->first()->deskripsi, 120) }}</p>
              
              <div class="product-details" id="product-details">
                <div class="detail-item">
                  <i class="fas fa-tag"></i>
                  <span>Rp{{ number_format($products->first()->harga, 0, ',', '.') }}</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-boxes"></i>
                  <span>Stok: {{ $products->first()->jumlah_produk }}</span>
                </div>
              </div>

              @auth
                <a href="/product" class="btn-detail-link">
                  <button class="btn-detail">
                    <i class="fas fa-eye"></i>
                    Lihat Detail
                  </button>
                </a>
              @else
                <button class="btn-detail" id="btnDetailProduk">
                  <i class="fas fa-eye"></i>
                  Lihat Detail
                </button>
              @endauth

              <div class="dots-navigation">
                @foreach ($products as $index => $product)
                  <button class="dot {{ $index === 0 ? 'active' : '' }}" 
                          data-slide="{{ $index }}"
                          aria-label="Go to product {{ $index + 1 }}"></button>
                @endforeach
              </div>
            </div>

            <button class="arrow-direction-right" aria-label="Next product">
              <i class="fas fa-chevron-right"></i>
            </button>
          @else
            <div class="no-products">
              <i class="fas fa-box-open"></i>
              <p>Tidak ada produk tersedia saat ini.</p>
              <small>Silakan kembali lagi nanti untuk melihat produk terbaru kami.</small>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Choice Section -->
  <section class="choice-section">
    <div class="container">
      <h2 class="section-title">
        Mengapa Memilih Kami?
        <span class="title-underline"></span>
      </h2>
      
      <div class="choice-cards">
        <div class="choice-card choice-card-red">
          <div class="choice-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <h3>100% Organik</h3>
          <p>Produk organik asli tanpa bahan kimia berbahaya</p>
        </div>
        
        <div class="choice-card choice-card-yellow">
          <div class="choice-icon">
            <i class="fas fa-award"></i>
          </div>
          <h3>Kualitas Terbaik</h3>
          <p>Bahan berkualitas tinggi dengan standar internasional</p>
        </div>
        
        <div class="choice-card choice-card-green">
          <div class="choice-icon">
            <i class="fas fa-heart"></i>
          </div>
          <h3>Rasa Autentik</h3>
          <p>Cita rasa lokal yang enak dan menyehatkan</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Recommendation -->
  <section class="recommendation-section">
    <div class="container">
      <div class="recommendation-grid">
        <div class="recommendation-content">
          <p class="recommendation-subtitle">Rekomendasi Khusus</p>
          <h2>Produk Pilihan Terbaik</h2>
          <p class="recommendation-desc">Temukan berbagai produk soya berkualitas tinggi yang telah dipilih khusus untuk memenuhi kebutuhan gizi harian Anda. Dari tempe segar hingga susu kedelai murni, semua dibuat dengan standar kualitas terbaik.</p>
          @auth
            <button onclick="window.location.href='/product'" class="recommendation-btn">
              <i class="fas fa-arrow-right"></i>
              Lihat Semua Produk
            </button>
          @else
            <button id="lihatProdukBtn" class="recommendation-btn">
              <i class="fas fa-arrow-right"></i>
              Lihat Semua Produk
            </button>
          @endauth
        </div>
        <div class="recommendation-image">
          <div class="recommendation-placeholder">
            <i class="fas fa-seedling"></i>
            <span>Produk Soya Berkualitas</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Popular Product -->
  <section class="popular-section">
    <div class="container">
      <div class="popular-grid">
        <div class="popular-image">
          <div class="popular-placeholder">
            <i class="fas fa-fire"></i>
            <span>Produk Terpopuler</span>
          </div>
        </div>
        <div class="popular-content">
          <p class="popular-subtitle">Paling Diminati</p>
          <h2>Temukan Yang Pas Untuk Anda!</h2>
          <p class="popular-desc">Jelajahi koleksi lengkap produk soya kami yang telah terbukti menjadi favorit pelanggan. Setiap produk dibuat dengan resep tradisional yang telah diwariskan turun-temurun.</p>
          @auth
            <button onclick="window.location.href='/product'" class="popular-btn">
              <i class="fas fa-compass"></i>
              Jelajahi Sekarang
            </button>
          @else
            <button id="jelajahiBtn" class="popular-btn">
              <i class="fas fa-compass"></i>
              Jelajahi Sekarang
            </button>
          @endauth
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services-section">
    <div class="container">
      <h2 class="section-title">
        Layanan Catering Kami
        <span class="title-underline"></span>
      </h2>
      
      <div class="services-grid">
        <div class="services-list">
          <h3>Melayani Berbagai Acara</h3>
          <ul>
            <li>
              <i class="fas fa-heart"></i>
              <span>Pernikahan & Resepsi</span>
            </li>
            <li>
              <i class="fas fa-baby"></i>
              <span>Aqiqah & Syukuran</span>
            </li>
            <li>
              <i class="fas fa-child"></i>
              <span>Khitanan & Ulang Tahun</span>
            </li>
            <li>
              <i class="fas fa-mosque"></i>
              <span>Kegiatan Masjid & Pengajian</span>
            </li>
            <li>
              <i class="fas fa-users"></i>
              <span>Acara Komunitas & Lainnya</span>
            </li>
          </ul>
        </div>
        
        <div class="services-gallery">
          <div class="service-img service-img-1">
            <div class="service-overlay">
              <i class="fas fa-utensils"></i>
              <span>Catering Premium</span>
            </div>
          </div>
          <div class="service-img service-img-2">
            <div class="service-overlay">
              <i class="fas fa-birthday-cake"></i>
              <span>Paket Acara</span>
            </div>
          </div>
          <div class="service-img service-img-3">
            <div class="service-overlay">
              <i class="fas fa-handshake"></i>
              <span>Konsultasi Menu</span>
            </div>
          </div>
          <div class="service-img service-img-4">
            <div class="service-overlay">
              <i class="fas fa-truck"></i>
              <span>Delivery Service</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section class="map-section">
    <div class="container">
      <h2 class="section-title">
        Lokasi Kami
        <span class="title-underline"></span>
      </h2>
      <div class="map-container">
        <div class="map-placeholder">
          <i class="fas fa-map-marker-alt"></i>
          <div class="map-info">
            <h3>Budhi Soya Foods</h3>
            <p>Kunjungi toko kami untuk pengalaman berbelanja langsung</p>
            <button class="map-btn">
              <i class="fas fa-directions"></i>
              Lihat di Google Maps
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <h3>Budhi Soya Foods</h3>
          <p>Menyediakan produk soya berkualitas tinggi untuk gaya hidup sehat Anda. Dipercaya sejak bertahun-tahun sebagai produsen makanan sehat terbaik.</p>
          <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
        
        <div class="footer-col">
          <h4>Produk Kami</h4>
          <ul>
            <li><a href="#">Tempe Segar</a></li>
            <li><a href="#">Tahu Premium</a></li>
            <li><a href="#">Susu Kedelai</a></li>
            <li><a href="#">Produk Olahan</a></li>
          </ul>
        </div>
        
        <div class="footer-col">
          <h4>Layanan</h4>
          <ul>
            <li><a href="#">Catering Acara</a></li>
            <li><a href="#">Pesanan Khusus</a></li>
            <li><a href="#">Konsultasi Gizi</a></li>
            <li><a href="#">Delivery Service</a></li>
          </ul>
        </div>
        
        <div class="footer-col">
          <h4>Hubungi Kami</h4>
          <div class="footer-contact">
            <p><i class="fas fa-phone"></i> +62 123 456 789</p>
            <p><i class="fas fa-envelope"></i> info@budhisoya.com</p>
            <p><i class="fas fa-map-marker-alt"></i> Jl. Contoh No. 123, Kota</p>
            <p><i class="fas fa-clock"></i> Senin - Sabtu: 08:00 - 17:00</p>
          </div>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; 2024 Budhi Soya Foods. Semua hak dilindungi undang-undang.</p>
      </div>
    </div>
  </footer>

  <!-- Login Modal -->
  <div id="loginModal" class="login-modal" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
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

  <script>
    // Pass products data to JavaScript
    const products = @json($products);
  </script>

</body>
</html>