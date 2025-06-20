
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produk - Budhi Soya Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/product.css">
</head>
<body>
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="hero-product">
        <div class="hero-content">
            <h1>Produk Kami</h1>
            <p>Temukan berbagai produk soya berkualitas tinggi yang dibuat dengan penuh cinta</p>
            @auth
                <div class="user-welcome">
                    <i class="fas fa-user-circle"></i>
                    <span>Selamat datang, {{ Auth::user()->username }}!</span>
                </div>
            @endauth
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-controls">
                <h3>Filter Produk</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-category="all">
                        <i class="fas fa-th"></i> Semua
                    </button>
                    <button class="filter-btn" data-category="Makanan">
                        <i class="fas fa-utensils"></i> Makanan
                    </button>
                    <button class="filter-btn" data-category="Minuman">
                        <i class="fas fa-glass-water"></i> Minuman
                    </button>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari produk...">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            @if($products->isNotEmpty())
                <div class="products-grid" id="productsGrid">
                    @foreach($products as $product)
                        <div class="product-card" data-category="{{ $product->kategori }}" data-name="{{ strtolower($product->nama_produk) }}">
                            <div class="product-image">
                                @if($product->foto)
                                    <img src="{{ asset('uploads/products/' . $product->foto) }}" alt="{{ $product->nama_produk }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                                <div class="product-badge">
                                    <i class="fas fa-leaf"></i>
                                    {{ $product->kategori }}
                                </div>
                                <div class="product-overlay">
                                    <button class="btn-detail" onclick="showProductDetail({{ $product->id_produk }})">
                                        <i class="fas fa-eye"></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->nama_produk }}</h3>
                                <p class="product-description">{{ Str::limit($product->deskripsi, 80) }}</p>
                                <div class="product-meta">
                                    <div class="product-price">
                                        <i class="fas fa-tag"></i>
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </div>
                                    <div class="product-stock">
                                        <i class="fas fa-boxes"></i>
                                        Stok: {{ $product->jumlah_produk }}
                                    </div>
                                </div>
                                @auth
                                    <div class="product-actions">
                                        <button class="btn-cart" onclick="addToCart({{ $product->id_produk }})">
                                            <i class="fas fa-shopping-cart"></i>
                                            Tambah ke Keranjang
                                        </button>
                                    </div>
                                @else
                                    <div class="product-actions">
                                        <button class="btn-login" onclick="redirectToLogin()">
                                            <i class="fas fa-sign-in-alt"></i>
                                            Login untuk Membeli
                                        </button>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <h3>Belum Ada Produk</h3>
                    <p>Saat ini belum ada produk yang tersedia. Silakan kembali lagi nanti.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Product Detail Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeProductModal()">&times;</span>
            <div id="modalContent">
                <!-- Product detail will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <script src="/assets/js/product.js"></script>
</body>
</html>
