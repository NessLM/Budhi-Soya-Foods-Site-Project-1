
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

    <!-- Products Section with Sidebar -->
    <section class="products-section">
        <div class="container">
            <div class="products-layout">
                <!-- Products Grid -->
                <div class="products-main">
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
                                                <button class="btn-add-to-selection" onclick="addToSelection({{ $product->id_produk }}, '{{ $product->nama_produk }}', {{ $product->harga }}, {{ $product->jumlah_produk }}, '{{ $product->foto }}')">
                                                    <i class="fas fa-plus"></i>
                                                    Pilih Produk
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

                <!-- Order Sidebar -->
                @auth
                <div class="order-sidebar">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-shopping-basket"></i> Pesanan Saya</h3>
                        <button class="clear-selection-btn" onclick="clearSelection()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="selected-products" id="selectedProducts">
                        <div class="empty-selection">
                            <i class="fas fa-shopping-basket"></i>
                            <p>Belum ada produk dipilih</p>
                        </div>
                    </div>
                    
                    <div class="order-summary" id="orderSummary" style="display: none;">
                        <div class="summary-item">
                            <span>Total Item:</span>
                            <span id="totalItems">0</span>
                        </div>
                        <div class="summary-item total">
                            <span>Total Harga:</span>
                            <span id="totalPrice">Rp 0</span>
                        </div>
                        <button class="btn-proceed-order" onclick="showOrderForm()">
                            <i class="fas fa-credit-card"></i>
                            Lanjut Pesan
                        </button>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </section>

    <!-- Order Form Modal -->
    @auth
    <div id="orderFormModal" class="modal">
        <div class="modal-content order-form-modal">
            <span class="close" onclick="closeOrderForm()">&times;</span>
            <div class="modal-header">
                <h2><i class="fas fa-clipboard-list"></i> Form Pemesanan</h2>
            </div>
            <form id="orderForm" onsubmit="submitOrder(event)">
                @csrf
                <div class="form-grid">
                    <div class="form-section">
                        <h3>Informasi Pemesan</h3>
                        <div class="form-group">
                            <label for="nama_pemesan">Nama Pemesan *</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_lengkap">Alamat Lengkap *</label>
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="postal_code">Kode Pos *</label>
                                <input type="text" id="postal_code" name="postal_code" required>
                            </div>
                            <div class="form-group">
                                <label for="provinsi">Provinsi *</label>
                                <input type="text" id="provinsi" name="provinsi" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Ringkasan Pesanan</h3>
                        <div class="order-items-summary" id="orderItemsSummary">
                            <!-- Items will be populated by JavaScript -->
                        </div>
                        <div class="order-total-summary">
                            <div class="summary-row">
                                <span>Total Item:</span>
                                <span id="formTotalItems">0</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total Pembayaran:</span>
                                <span id="formTotalPrice">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeOrderForm()">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endauth

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
