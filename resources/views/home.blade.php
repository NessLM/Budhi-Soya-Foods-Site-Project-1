<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Budhi Soya Foods</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/css/home.css" />
</head>
<body class="font-sans bg-white">
  <x-navbar></x-navbar>

  <section class="hero-section">
    <div class="hero-section-item">
      <div class="hero-section-content">
        <h1>Soya Foods</h1>
        <p>Bergizi, organik, dan dibuat secara lokal dengan penuh cinta. Mulailah gaya hidup sehatmu bersama kami</p>
        <button>Pesan Produk</button>
      </div>
      <div class="hero-image" ></div>
    </div>
  </section>

  <!-- Section -->
  <section class="body-section">
    <div class="main-product">
      <h2>Produk Utama Kami</h2>
      <div class="main-product-slider">
        <div class="product-card active">
          <div class="product-image">
            <img src="https://via.placeholder.com/400x300" alt="Susu Kedelai Original">
          </div>
          <div class="product-info">
            <h3>Susu Kedelai Original</h3>
            <p class="desc">Susu kedelai murni tanpa tambahan gula, cocok untuk semua kalangan.</p>
            <div class="stock-price">
              <span>Stok: 50</span>
              <span>Harga: Rp10.000</span>
            </div>
            <button class="btn-detail">Detail Produk</button>
          </div>
        </div>

        <div class="product-card active">
          <div class="product-image">
            <img src="https://via.placeholder.com/400x300" alt="Susu Kedelai Original">
          </div>
          <div class="product-info">
            <h3>Susu Kedelai Original</h3>
            <p class="desc">Susu kedelai murni tanpa tambahan gula, cocok untuk semua kalangan.</p>
            <div class="stock-price">
              <span>Stok: 50</span>
              <span>Harga: Rp10.000</span>
            </div>
            <button class="btn-detail">Detail Produk</button>
          </div>
        </div>
        <!-- Tambahkan lebih banyak .product-card sesuai kebutuhan -->
      </div>
      <div class="slider-controls">
        <button class="prev">&#10094;</button>
        <div class="dots">
          <span class="dot active"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>
        <button class="next">&#10095;</button>
      </div>
    </div>
  </section>

  <script src="/assets/js/home.js"></script>

</body>

</html>
