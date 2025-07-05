
// Product Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeProductPage();
});

function initializeProductPage() {
    // Initialize filter functionality
    initializeFilters();
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize modal functionality
    initializeModal();
    
    // Add smooth scrolling
    document.documentElement.style.scrollBehavior = 'smooth';
}

// Filter Functions
function initializeFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter products
            filterProducts(category);
        });
    });
}

function filterProducts(category) {
    const productCards = document.querySelectorAll('.product-card');
    let visibleCount = 0;
    
    productCards.forEach(card => {
        const cardCategory = card.dataset.category;
        
        if (category === 'all' || cardCategory === category) {
            card.classList.remove('hidden');
            // Add animation
            setTimeout(() => {
                card.style.transform = 'translateY(0)';
                card.style.opacity = '1';
            }, visibleCount * 50);
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    // Update grid if no products found
    updateNoProductsMessage(visibleCount, category);
}

// Search Functions
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        searchProducts(searchTerm);
    });
}

function searchProducts(searchTerm) {
    const productCards = document.querySelectorAll('.product-card');
    const activeFilter = document.querySelector('.filter-btn.active').dataset.category;
    let visibleCount = 0;
    
    productCards.forEach(card => {
        const productName = card.dataset.name;
        const cardCategory = card.dataset.category;
        
        const matchesSearch = productName.includes(searchTerm);
        const matchesFilter = activeFilter === 'all' || cardCategory === activeFilter;
        
        if (matchesSearch && matchesFilter) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    updateNoProductsMessage(visibleCount, activeFilter, searchTerm);
}

function updateNoProductsMessage(visibleCount, category, searchTerm = '') {
    const productsGrid = document.getElementById('productsGrid');
    let existingMessage = document.querySelector('.no-products-filtered');
    
    if (existingMessage) {
        existingMessage.remove();
    }
    
    if (visibleCount === 0) {
        const message = document.createElement('div');
        message.className = 'no-products no-products-filtered';
        message.innerHTML = `
            <i class="fas fa-search"></i>
            <h3>Tidak Ada Produk Ditemukan</h3>
            <p>${searchTerm ? `Tidak ada produk yang cocok dengan pencarian "${searchTerm}"` : `Tidak ada produk dalam kategori "${category}"`}</p>
            <button class="btn-clear-filter" onclick="clearFilters()">
                <i class="fas fa-undo"></i>
                Hapus Filter
            </button>
        `;
        productsGrid.parentNode.appendChild(message);
    }
}

function clearFilters() {
    // Reset search
    document.getElementById('searchInput').value = '';
    
    // Reset filter to "all"
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector('.filter-btn[data-category="all"]').classList.add('active');
    
    // Show all products
    filterProducts('all');
}

// Modal Functions
function initializeModal() {
    const modal = document.getElementById('productModal');
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeProductModal();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProductModal();
        }
    });
}

function showProductDetail(productId) {
    const modal = document.getElementById('productModal');
    const modalContent = document.getElementById('modalContent');
    
    // Show loading
    modalContent.innerHTML = `
        <div style="text-align: center; padding: 60px;">
            <div class="loading"></div>
            <p style="margin-top: 20px; color: #6c757d;">Memuat detail produk...</p>
        </div>
    `;
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Fetch product details
    fetch(`/api/product/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayProductDetail(data.product);
            } else {
                showError('Gagal memuat detail produk');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Terjadi kesalahan saat memuat data');
        });
}

function displayProductDetail(product) {
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <div class="product-detail">
            <div class="product-detail-image">
                ${product.foto ? 
                    `<img src="/uploads/products/${product.foto}" alt="${product.nama_produk}">` :
                    `<div class="no-image">
                        <i class="fas fa-image"></i>
                        <span>No Image</span>
                    </div>`
                }
                <div class="product-badge-large">
                    <i class="fas fa-leaf"></i>
                    ${product.kategori}
                </div>
            </div>
            <div class="product-detail-info">
                <h2>${product.nama_produk}</h2>
                <div class="product-detail-meta">
                    <div class="price-large">
                        <i class="fas fa-tag"></i>
                        Rp ${new Intl.NumberFormat('id-ID').format(product.harga)}
                    </div>
                    <div class="stock-large">
                        <i class="fas fa-boxes"></i>
                        Stok: ${product.jumlah_produk}
                    </div>
                </div>
                <div class="product-description-full">
                    <h4>Deskripsi Produk</h4>
                    <p>${product.deskripsi}</p>
                </div>
                <div class="product-detail-actions">
                    ${window.authUser ? 
                        `<button class="btn-cart-large" onclick="addToCart(${product.id_produk})">
                            <i class="fas fa-shopping-cart"></i>
                            Tambah ke Keranjang
                        </button>
                        <button class="btn-buy-now" onclick="buyNow(${product.id_produk})">
                            <i class="fas fa-bolt"></i>
                            Beli Sekarang
                        </button>` :
                        `<button class="btn-login-large" onclick="redirectToLogin()">
                            <i class="fas fa-sign-in-alt"></i>
                            Login untuk Membeli
                        </button>`
                    }
                </div>
            </div>
        </div>
    `;
    
    // Add styles for product detail modal
    addProductDetailStyles();
}

function addProductDetailStyles() {
    if (!document.getElementById('productDetailStyles')) {
        const style = document.createElement('style');
        style.id = 'productDetailStyles';
        style.textContent = `
            .product-detail {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 40px;
                padding: 40px;
            }
            
            .product-detail-image {
                position: relative;
            }
            
            .product-detail-image img {
                width: 100%;
                height: 400px;
                object-fit: cover;
                border-radius: 15px;
            }
            
            .product-badge-large {
                position: absolute;
                top: 20px;
                left: 20px;
                background: #26472a;
                color: white;
                padding: 10px 20px;
                border-radius: 20px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .product-detail-info h2 {
                font-size: 2rem;
                color: #212529;
                margin-bottom: 20px;
                line-height: 1.3;
            }
            
            .product-detail-meta {
                display: flex;
                gap: 30px;
                margin-bottom: 30px;
                padding: 20px;
                background: #f8f9fa;
                border-radius: 10px;
            }
            
            .price-large,
            .stock-large {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 600;
            }
            
            .price-large {
                color: #26472a;
                font-size: 1.5rem;
            }
            
            .stock-large {
                color: #6c757d;
                font-size: 1.1rem;
            }
            
            .product-description-full h4 {
                color: #26472a;
                margin-bottom: 15px;
                font-size: 1.2rem;
            }
            
            .product-description-full p {
                color: #6c757d;
                line-height: 1.6;
                margin-bottom: 30px;
            }
            
            .product-detail-actions {
                display: flex;
                gap: 15px;
            }
            
            .btn-cart-large,
            .btn-buy-now,
            .btn-login-large {
                flex: 1;
                padding: 15px 25px;
                border: none;
                border-radius: 10px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                font-size: 1rem;
            }
            
            .btn-cart-large {
                background: #26472a;
                color: white;
            }
            
            .btn-cart-large:hover {
                background: #1a3b1d;
                transform: translateY(-2px);
            }
            
            .btn-buy-now {
                background: #53ff4e;
                color: #1a3b1d;
            }
            
            .btn-buy-now:hover {
                background: #4de045;
                transform: translateY(-2px);
            }
            
            .btn-login-large {
                background: #53ff4e;
                color: #1a3b1d;
            }
            
            .btn-login-large:hover {
                background: #4de045;
                transform: translateY(-2px);
            }
            
            @media (max-width: 768px) {
                .product-detail {
                    grid-template-columns: 1fr;
                    gap: 20px;
                    padding: 20px;
                }
                
                .product-detail-meta {
                    flex-direction: column;
                    gap: 15px;
                    text-align: center;
                }
                
                .product-detail-actions {
                    flex-direction: column;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function showError(message) {
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div style="text-align: center; padding: 60px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #dc3545; margin-bottom: 20px;"></i>
            <h3 style="color: #dc3545; margin-bottom: 10px;">Error</h3>
            <p style="color: #6c757d;">${message}</p>
            <button onclick="closeProductModal()" style="margin-top: 20px; padding: 10px 20px; background: #26472a; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Tutup
            </button>
        </div>
    `;
}

// Selection Management
let selectedProducts = [];

function addToSelection(productId, productName, price, stock, photo) {
    // Check if product already selected
    const existingIndex = selectedProducts.findIndex(item => item.id === productId);
    
    if (existingIndex !== -1) {
        // Increase quantity if already selected
        if (selectedProducts[existingIndex].quantity < stock) {
            selectedProducts[existingIndex].quantity++;
            updateSidebar();
            showNotification('Jumlah produk ditambahkan!', 'success');
        } else {
            showNotification('Stok tidak mencukupi!', 'warning');
        }
    } else {
        // Add new product to selection
        selectedProducts.push({
            id: productId,
            name: productName,
            price: price,
            stock: stock,
            photo: photo,
            quantity: 1
        });
        updateSidebar();
        showNotification('Produk ditambahkan ke pilihan!', 'success');
    }
}

function removeFromSelection(productId) {
    selectedProducts = selectedProducts.filter(item => item.id !== productId);
    updateSidebar();
    showNotification('Produk dihapus dari pilihan!', 'info');
}

function updateQuantity(productId, newQuantity) {
    const productIndex = selectedProducts.findIndex(item => item.id === productId);
    if (productIndex !== -1) {
        const product = selectedProducts[productIndex];
        if (newQuantity > 0 && newQuantity <= product.stock) {
            selectedProducts[productIndex].quantity = newQuantity;
            updateSidebar();
        } else if (newQuantity > product.stock) {
            showNotification('Jumlah melebihi stok yang tersedia!', 'warning');
        }
    }
}

function clearSelection() {
    selectedProducts = [];
    updateSidebar();
    showNotification('Semua pilihan dibersihkan!', 'info');
}

function updateSidebar() {
    const selectedProductsContainer = document.getElementById('selectedProducts');
    const orderSummary = document.getElementById('orderSummary');
    
    if (selectedProducts.length === 0) {
        selectedProductsContainer.innerHTML = `
            <div class="empty-selection">
                <i class="fas fa-shopping-basket"></i>
                <p>Belum ada produk dipilih</p>
            </div>
        `;
        orderSummary.style.display = 'none';
        return;
    }
    
    let html = '';
    let totalItems = 0;
    let totalPrice = 0;
    
    selectedProducts.forEach(product => {
        const itemTotal = product.price * product.quantity;
        totalItems += product.quantity;
        totalPrice += itemTotal;
        
        html += `
            <div class="selected-item">
                <div class="selected-item-header">
                    <div class="selected-item-info">
                        <h4>${product.name}</h4>
                        <div class="selected-item-price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</div>
                    </div>
                    <button class="remove-item-btn" onclick="removeFromSelection(${product.id})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="quantity-control">
                    <label>Jumlah:</label>
                    <input type="number" class="quantity-input" value="${product.quantity}"
                           min="1" max="${product.stock}"
                           onchange="updateQuantity(${product.id}, parseInt(this.value))">
                </div>
                <div class="stock-info">Stok: ${product.stock}</div>
            </div>
        `;
    });
    
    selectedProductsContainer.innerHTML = html;
    
    // Update summary
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalPrice').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(totalPrice)}`;
    orderSummary.style.display = 'block';
}

// Order Form Functions
function showOrderForm() {
    if (selectedProducts.length === 0) {
        showNotification('Pilih produk terlebih dahulu!', 'warning');
        return;
    }
    
    const modal = document.getElementById('orderFormModal');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Populate order summary in form
    updateOrderFormSummary();
}

function closeOrderForm() {
    const modal = document.getElementById('orderFormModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function updateOrderFormSummary() {
    const orderItemsSummary = document.getElementById('orderItemsSummary');
    const formTotalItems = document.getElementById('formTotalItems');
    const formTotalPrice = document.getElementById('formTotalPrice');
    
    let html = '';
    let totalItems = 0;
    let totalPrice = 0;
    
    selectedProducts.forEach(product => {
        const itemTotal = product.price * product.quantity;
        totalItems += product.quantity;
        totalPrice += itemTotal;
        
        html += `
            <div class="summary-item-row">
                <span>${product.name} x${product.quantity}</span>
                <span>Rp ${new Intl.NumberFormat('id-ID').format(itemTotal)}</span>
            </div>
        `;
    });
    
    orderItemsSummary.innerHTML = html;
    formTotalItems.textContent = totalItems;
    formTotalPrice.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(totalPrice)}`;
}

function submitOrder(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const orderData = {
        nama_pemesan: formData.get('nama_pemesan'),
        alamat_lengkap: formData.get('alamat_lengkap'),
        postal_code: formData.get('postal_code'),
        provinsi: formData.get('provinsi'),
        products: selectedProducts
    };
    
    // Show loading state
    const submitBtn = event.target.querySelector('.btn-submit');
    const originalHTML = submitBtn.innerHTML;
    submitBtn.innerHTML = '<div class="loading"></div> Memproses...';
    submitBtn.disabled = true;
    
    // Send order to server
    fetch('/orders/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Pesanan berhasil dibuat!', 'success');
            closeOrderForm();
            clearSelection();
            
            // Redirect immediately to orders page
            window.location.href = '/orders';
        } else {
            showNotification(data.message || 'Gagal membuat pesanan!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses pesanan!', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalHTML;
        submitBtn.disabled = false;
    });
}

// Legacy cart function (keep for compatibility)
function addToCart(productId) {
    // Show loading state
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<div class="loading"></div> Menambahkan...';
    button.disabled = true;
    
    // Simulate API call (replace with actual implementation)
    setTimeout(() => {
        // Reset button
        button.innerHTML = originalHTML;
        button.disabled = false;
        
        // Show success message
        showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
        
        // Update cart count (if you have cart counter)
        updateCartCount();
    }, 1000);
}

function buyNow(productId) {
    // Redirect to checkout or show buy now modal
    showNotification('Mengarahkan ke halaman checkout...', 'info');
    
    // Simulate redirect
    setTimeout(() => {
        // window.location.href = `/checkout/${productId}`;
        console.log(`Buying product ${productId}`);
    }, 1000);
}

function redirectToLogin() {
    window.location.href = '/login';
}

// Utility Functions
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${getNotificationIcon(type)}"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Add notification styles
    addNotificationStyles();
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 3000);
}

function getNotificationIcon(type) {
    switch (type) {
        case 'success': return 'fa-check-circle';
        case 'error': return 'fa-exclamation-circle';
        case 'warning': return 'fa-exclamation-triangle';
        default: return 'fa-info-circle';
    }
}

function addNotificationStyles() {
    if (!document.getElementById('notificationStyles')) {
        const style = document.createElement('style');
        style.id = 'notificationStyles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.15);
                animation: slideInRight 0.3s ease;
            }
            
            .notification-content {
                padding: 15px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .notification-success {
                border-left: 4px solid #28a745;
            }
            
            .notification-error {
                border-left: 4px solid #dc3545;
            }
            
            .notification-warning {
                border-left: 4px solid #ffc107;
            }
            
            .notification-info {
                border-left: 4px solid #17a2b8;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: #6c757d;
                cursor: pointer;
                margin-left: auto;
                padding: 5px;
            }
            
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

function updateCartCount() {
    // Update cart counter in navbar if exists
    const cartCounter = document.querySelector('.cart-counter');
    if (cartCounter) {
        const currentCount = parseInt(cartCounter.textContent) || 0;
        cartCounter.textContent = currentCount + 1;
    }
}

// Check if user is authenticated (set this from Laravel)

