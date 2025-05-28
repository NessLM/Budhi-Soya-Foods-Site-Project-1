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

  <section class="body-section bg-[#dff2e0] rounded-t-[3rem] px-6 py-12">
    <h2 class="text-2xl font-bold text-center mb-10">
      Produk Utama Kami
      <span class="block h-1 w-24 bg-green-500 mx-auto mt-2 rounded-full"></span>
    </h2>
  
    <!-- Wrapper Slider -->
    <div class="main-product-slider overflow-hidden relative max-w-6xl mx-auto">
      <!-- Track / Container yang digeser -->
      <div id="slider-track" class="flex transition-transform duration-500 ease-in-out">
        
        <!-- Slide 1 -->
        <div class="product-slide shrink-0 w-full flex flex-wrap items-center justify-center gap-6 bg-[#3f704d] p-6 rounded-3xl relative shadow-lg">
          <div class="w-full md:w-1/2 p-3">
            <img src="https://images.unsplash.com/photo-1635861324414-0e9891038a74" alt="Susu Kedelai" class="rounded-xl border-4 border-green-300 shadow-md w-full object-cover h-80">
          </div>
          <div class="w-full md:w-1/2 text-white px-4 space-y-4">
            <h3 class="text-2xl font-bold">Susu Kedelai Premium</h3>
            <p class="text-sm">Terbuat dari kedelai murni pilihan, tanpa pengawet dan tambahan gula. Ideal untuk gaya hidup sehat.</p>
            <div class="flex justify-between text-sm mt-4">
              <span>Stok: 25</span>
              <span>Harga: Rp 50.000</span>
            </div>
            <button class="mt-4 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-xl transition duration-300">Detail Produk</button>
          </div>
        </div>
  
        <!-- Slide 2 -->
        <div class="product-slide shrink-0 w-full flex flex-wrap items-center justify-center gap-6 bg-[#3f704d] p-6 rounded-3xl relative shadow-lg">
          <div class="w-full md:w-1/2 p-3">
            <img src="https://images.unsplash.com/photo-1606857521015-c7bbfd3a9ac6" alt="Susu Kedelai Rasa Vanila" class="rounded-xl border-4 border-green-300 shadow-md w-full object-cover h-80">
          </div>
          <div class="w-full md:w-1/2 text-white px-4 space-y-4">
            <h3 class="text-2xl font-bold">Susu Kedelai Rasa Vanila</h3>
            <p class="text-sm">Nikmati kelembutan rasa vanila yang manis dan lembut dalam setiap tegukan susu kedelai kami.</p>
            <div class="flex justify-between text-sm mt-4">
              <span>Stok: 40</span>
              <span>Harga: Rp 55.000</span>
            </div>
            <button class="mt-4 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-xl transition duration-300">Detail Produk</button>
          </div>
        </div>
  
        <!-- Slide 3 -->
        <div class="product-slide shrink-0 w-full flex flex-wrap items-center justify-center gap-6 bg-[#3f704d] p-6 rounded-3xl relative shadow-lg">
          <div class="w-full md:w-1/2 p-3">
            <img src="https://images.unsplash.com/photo-1615484478059-cf53b3f6b86e" alt="Susu Kedelai Cokelat" class="rounded-xl border-4 border-green-300 shadow-md w-full object-cover h-80">
          </div>
          <div class="w-full md:w-1/2 text-white px-4 space-y-4">
            <h3 class="text-2xl font-bold">Susu Kedelai Cokelat</h3>
            <p class="text-sm">Cocok untuk pecinta cokelat, susu kedelai ini memberikan rasa nikmat dan sehat sekaligus.</p>
            <div class="flex justify-between text-sm mt-4">
              <span>Stok: 18</span>
              <span>Harga: Rp 60.000</span>
            </div>
            <button class="mt-4 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-xl transition duration-300">Detail Produk</button>
          </div>
        </div>
      </div>
  
      <!-- Navigasi panah -->
      <button class="prev absolute left-4 top-1/2 -translate-y-1/2 bg-yellow-400 text-white w-8 h-8 rounded-full shadow-md flex items-center justify-center hover:bg-yellow-500 transition duration-300 z-10">&#10094;</button>
      <button class="next absolute right-4 top-1/2 -translate-y-1/2 bg-yellow-400 text-white w-8 h-8 rounded-full shadow-md flex items-center justify-center hover:bg-yellow-500 transition duration-300 z-10">&#10095;</button>
  
      <!-- Dot indikator -->
      <div class="dots absolute bottom-4 right-6 flex gap-3 items-center">
        <span class="dot w-6 h-3 rounded-full bg-white transition-all duration-300"></span>
        <span class="dot w-3 h-3 rounded-full bg-white/60 hover:scale-125 transition-all duration-300"></span>
        <span class="dot w-3 h-3 rounded-full bg-white/60 hover:scale-125 transition-all duration-300"></span>
      </div>
    </div>
  </section>
  
  

  <script src="/assets/js/home.js"></script>

</body>

</html>
