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

  <section class="home-container">
    <!-- Kiri: Teks dan Tombol -->
    <div class="home-text">
      <h1 class="home-title">Soya Foods</h1>
      <p class="home-desc">Bergizi, organik, dan dibuat secara lokal dengan penuh cinta. Mulailah gaya hidup sehatmu bersama kami.</p>
      <button class="home-button">Pesan Produk</button>
    </div>

    <!-- Kanan: Gambar -->
    <div class="home-image">
      <img src="/assets/img/hero-img.jpg" alt="Soya Dessert" />
    </div>
  </section>

  <!-- Produk Utama -->
  <section class="produk-section">
    <h2 class="produk-title">Produk Utama Kami</h2>
    <div class="produk-container">
      <div class="produk-item"></div>
      <div class="produk-item"></div>
      <div class="produk-item produk-highlight"></div>
    </div>
  </section>
</body>

</html>
