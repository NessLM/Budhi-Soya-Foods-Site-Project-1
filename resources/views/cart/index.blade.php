
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Budhi Soya Foods</title>
    <meta name="description" content="Keranjang belanja Anda di Budhi Soya Foods">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/cart.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="cart-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Keranjang Belanja</h1>
            <p>Review produk yang Anda pilih sebelum melanjutkan ke pembayaran</p>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="cart-section">
        <div class="container">
            @if($cartItems->count() > 0)
                <div class="cart-grid">
                    <!-- Cart Items -->
                    <div class="cart-items">
                        <div class="cart-header">
                            <h2>Produk dalam Keranjang ({{ $cartItems->sum('jumlah') }} item)</h2>
                            <button class="clear-cart-btn" onclick="clearCart()">
                                <i class="fas fa-trash"></i>
                                Kosongkan Keranjang
                            </button>
                        </div>

                        @foreach($cartItems as $item)
                            <div class="cart-item" data-item-id="{{ $item->id_cart }}">
                                <div class="item-image">
                                    <img src="{{ $item->product->foto ? '/uploads/products/' . $item->product->foto : '/assets/img/default-product.jpg' }}" 
                                         alt="{{ $item->product->nama_produk }}">
                                </div>
                                
                                <div class="item-details">
                                    <h3>{{ $item->product->nama_produk }}</h3>
                                    <p class="item-category">{{ $item->product->kategori }}</p>
                                    <p class="item-price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                    
                                    <div class="quantity-controls">
                                        <button class="quantity-btn minus" onclick="updateQuantity({{ $item->id_cart }}, -1)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="quantity-input" value="{{ $item->jumlah }}" 
                                               min="1" max="{{ $item->product->jumlah_produk }}"
                                               onchange="updateQuantity({{ $item->id_cart }}, 0, this.value)">
                                        <button class="quantity-btn plus" onclick="updateQuantity({{ $item->id_cart }}, 1)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                    <p class="stock-info">Stok tersedia: {{ $item->product->jumlah_produk }}</p>
                                </div>
                                
                                <div class="item-total">
                                    <p class="total-price" id="item-total-{{ $item->id_cart }}">
                                        Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}
                                    </p>
                                    <button class="remove-btn" onclick="removeItem({{ $item->id_cart }})">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="summary-card">
                            <h3>Ringkasan Belanja</h3>
                            
                            <div class="summary-item">
                                <span>Subtotal ({{ $cartItems->sum('jumlah') }} item)</span>
                                <span id="subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="summary-item">
                                <span>Ongkos Kirim</span>
                                <span class="shipping-fee">Gratis</span>
                            </div>
                            
                            <hr class="summary-divider">
                            
                            <div class="summary-total">
                                <span>Total</span>
                                <span id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <a href="{{ route('checkout') }}" class="checkout-btn">
                                <i class="fas fa-credit-card"></i>
                                Lanjut ke Pembayaran
                            </a>
                            
                            <a href="{{ route('product.index') }}" class="continue-shopping">
                                <i class="fas fa-arrow-left"></i>
                                Lanjut Belanja
                            </a>
                        </div>
                        
                        <!-- Promo Code -->
                        <div class="promo-card">
                            <h4>Kode Promo</h4>
                            <div class="promo-input">
                                <input type="text" placeholder="Masukkan kode promo">
                                <button class="apply-promo-btn">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Keranjang Belanja Kosong</h2>
                    <p>Anda belum menambahkan produk ke keranjang. Mari mulai berbelanja!</p>
                    <a href="{{ route('product.index') }}" class="shop-now-btn">
                        <i class="fas fa-shopping-bag"></i>
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Budhi Soya Foods</h3>
                    <p>Menyediakan produk soya berkualitas tinggi untuk gaya hidup sehat Anda.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('product.index') }}">Produk</a></li>
                        <li><a href="{{ route('aboutus') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
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
                    <h4>Informasi</h4>
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

    <script src="/assets/js/cart.js"></script>
</body>
</html>
