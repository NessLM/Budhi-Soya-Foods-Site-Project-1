// Auto slider functionality
document.addEventListener('DOMContentLoaded', function() {
    let currentSlide = 0;
    let slideInterval;
    const slideDelay = 5000; // 5 seconds
    
    // Check if products exist
    if (typeof products === 'undefined' || products.length === 0) {
        return;
    }
  
    // Get DOM elements
    const productImage = document.getElementById('product-image');
    const productTitle = document.getElementById('product-title');
    const productDesc = document.getElementById('product-desc');
    const productDetails = document.getElementById('product-details');
    const dots = document.querySelectorAll('.dot');
    const leftArrow = document.querySelector('.arrow-direction-left');
    const rightArrow = document.querySelector('.arrow-direction-right');
  
    // Function to update product display
    function updateProductDisplay(index) {
        if (!products[index]) return;
        
        const product = products[index];
        
        // Add fade out effect
        const elementsToFade = [productImage, productTitle, productDesc, productDetails];
        elementsToFade.forEach(el => {
            if (el) el.style.opacity = '0.3';
        });
        
        // Update content after short delay for smooth transition
        setTimeout(() => {
            if (productImage && product.foto) {
                productImage.src = `/uploads/products/${product.foto}`;
                productImage.alt = product.nama_produk;
            }
            
            if (productTitle) {
                productTitle.textContent = product.nama_produk;
            }
            
            if (productDesc && product.deskripsi) {
                // Limit description to 120 characters (similar to Laravel Str::limit)
                const limitedDesc = product.deskripsi.length > 120 
                    ? product.deskripsi.substring(0, 120) + '...' 
                    : product.deskripsi;
                productDesc.textContent = limitedDesc;
            }
            
            if (productDetails) {
                const harga = new Intl.NumberFormat('id-ID').format(product.harga);
                productDetails.innerHTML = `
                    <div class="detail-item">
                        <i class="fas fa-tag"></i>
                        <span>Rp${harga}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-boxes"></i>
                        <span>Stok: ${product.jumlah_produk}</span>
                    </div>
                `;
            }
            
            // Update badge with category
            const productBadge = document.querySelector('.product-badge');
            if (productBadge) {
                productBadge.innerHTML = `
                    <i class="fas fa-leaf"></i>
                    ${product.kategori}
                `;
            }
  
            // Update category display
            const productCategory = document.querySelector('.product-category');
            if (productCategory) {
                productCategory.textContent = product.kategori;
            }
            
            // Update dots
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            
            // Fade in effect
            setTimeout(() => {
                elementsToFade.forEach(el => {
                    if (el) el.style.opacity = '1';
                });
            }, 100);
            
        }, 200);
    }
  
    // Function to go to next slide
    function nextSlide() {
        currentSlide = (currentSlide + 1) % products.length;
        updateProductDisplay(currentSlide);
    }
  
    // Function to go to previous slide
    function prevSlide() {
        currentSlide = currentSlide === 0 ? products.length - 1 : currentSlide - 1;
        updateProductDisplay(currentSlide);
    }
  
    // Function to go to specific slide
    function goToSlide(index) {
        currentSlide = index;
        updateProductDisplay(currentSlide);
    }
  
    // Start auto slider
    function startAutoSlider() {
        slideInterval = setInterval(nextSlide, slideDelay);
    }
  
    // Stop auto slider
    function stopAutoSlider() {
        clearInterval(slideInterval);
    }
  
    // Restart auto slider
    function restartAutoSlider() {
        stopAutoSlider();
        startAutoSlider();
    }
  
    // Event listeners for arrows
    if (rightArrow) {
        rightArrow.addEventListener('click', () => {
            nextSlide();
            restartAutoSlider();
        });
    }
  
    if (leftArrow) {
        leftArrow.addEventListener('click', () => {
            prevSlide();
            restartAutoSlider();
        });
    }
  
    // Event listeners for dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            restartAutoSlider();
        });
    });
  
    // Pause auto slider on hover
    const productSlider = document.querySelector('.product-slider');
    if (productSlider) {
        productSlider.addEventListener('mouseenter', stopAutoSlider);
        productSlider.addEventListener('mouseleave', startAutoSlider);
    }
  
    // Initialize auto slider
    startAutoSlider();
  
    // Login modal functionality
    const loginModal = document.getElementById('loginModal');
    const closeModal = document.querySelector('.close-modal');
    
    // Buttons that require login
    const loginRequiredButtons = [
        'pesanProdukBtn',
        'btnDetailProduk', 
        'lihatProdukBtn',
        'jelajahiBtn',
        'produkNav',
        'contactNav',
        'aboutusNav'
    ];
  
    // Show login modal
    function showLoginModal() {
        if (loginModal) {
            loginModal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    }
  
    // Hide login modal
    function hideLoginModal() {
        if (loginModal) {
            loginModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    }
  
    // Add event listeners for login required buttons
    loginRequiredButtons.forEach(buttonId => {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                showLoginModal();
            });
        }
    });
  
    // Close modal event listeners
    if (closeModal) {
        closeModal.addEventListener('click', hideLoginModal);
    }
  
    // Close modal when clicking outside
    if (loginModal) {
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                hideLoginModal();
            }
        });
    }
  
    // Handle modal button clicks (no need to prevent default since they're links)
    const modalButtons = document.querySelectorAll('.modal-login-btn, .modal-register-btn');
    modalButtons.forEach(button => {
        button.addEventListener('click', () => {
            hideLoginModal(); // Hide modal before navigation
        });
    });
  
    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && loginModal && loginModal.style.display === 'block') {
            hideLoginModal();
        }
    });
  
    // Smooth scrolling for anchor links (if any)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
  
    // Add loading animation for images
    const productImages = document.querySelectorAll('.img-product img');
    productImages.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.style.opacity = '0.5';
            this.alt = 'Image not found';
        });
    });
  
    // Intersection Observer for animations (optional enhancement)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
  
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
  
    // Observe sections for scroll animations
    const sectionsToAnimate = document.querySelectorAll('.choice-section, .recommendation-section, .popular-section, .services-section');
    sectionsToAnimate.forEach(section => {
        observer.observe(section);
    });
});
  
// Additional utility functions
function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}
  
// Handle window resize for responsive adjustments
window.addEventListener('resize', function() {
    // Adjust slider height if needed
    const productSlider = document.querySelector('.product-slider');
    if (productSlider && window.innerWidth <= 768) {
        productSlider.style.flexDirection = 'column';
        productSlider.style.height = 'auto';
    } else if (productSlider) {
        productSlider.style.flexDirection = 'row';
        productSlider.style.height = '26.5rem';
    }
});
  
// Performance optimization: Preload next images
function preloadNextImage() {
    if (typeof products !== 'undefined' && products.length > 1) {
        const nextIndex = (currentSlide + 1) % products.length;
        const nextProduct = products[nextIndex];
        if (nextProduct && nextProduct.foto) {
            const img = new Image();
            img.src = `/uploads/products/${nextProduct.foto}`;
        }
    }
}
  
// Call preload after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(preloadNextImage, 5000);
});