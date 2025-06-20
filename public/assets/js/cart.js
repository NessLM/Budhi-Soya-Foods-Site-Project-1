
// Cart functionality
document.addEventListener('DOMContentLoaded', function() {
    // Set up CSRF token for AJAX requests
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.csrfToken = token.getAttribute('content');
    }
});

// Update cart item quantity
function updateQuantity(itemId, change, newValue = null) {
    const quantityInput = document.querySelector(`.cart-item[data-item-id="${itemId}"] .quantity-input`);
    let quantity;
    
    if (newValue !== null) {
        quantity = parseInt(newValue);
    } else {
        quantity = parseInt(quantityInput.value) + change;
    }
    
    if (quantity < 1) {
        quantity = 1;
    }
    
    const maxStock = parseInt(quantityInput.getAttribute('max'));
    if (quantity > maxStock) {
        showNotification('Jumlah melebihi stok yang tersedia', 'error');
        return;
    }
    
    // Show loading state
    const cartItem = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
    cartItem.style.opacity = '0.6';
    
    fetch(`/cart/update/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            quantityInput.value = quantity;
            document.getElementById(`item-total-${itemId}`).textContent = `Rp ${data.item_total}`;
            updateCartTotals();
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memperbarui keranjang', 'error');
    })
    .finally(() => {
        cartItem.style.opacity = '1';
    });
}

// Remove item from cart
function removeItem(itemId) {
    if (!confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
        return;
    }
    
    const cartItem = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
    cartItem.style.opacity = '0.6';
    
    fetch(`/cart/remove/${itemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cartItem.remove();
            updateCartTotals();
            updateCartCounter(data.cart_count);
            showNotification(data.message, 'success');
            
            // Check if cart is empty
            const remainingItems = document.querySelectorAll('.cart-item');
            if (remainingItems.length === 0) {
                location.reload();
            }
        } else {
            showNotification('Terjadi kesalahan saat menghapus produk', 'error');
            cartItem.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat menghapus produk', 'error');
        cartItem.style.opacity = '1';
    });
}

// Clear entire cart
function clearCart() {
    if (!confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
        return;
    }
    
    fetch('/cart/clear', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('Terjadi kesalahan saat mengosongkan keranjang', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengosongkan keranjang', 'error');
    });
}

// Update cart totals
function updateCartTotals() {
    let subtotal = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const itemId = item.getAttribute('data-item-id');
        const quantity = parseInt(item.querySelector('.quantity-input').value);
        const price = parseFloat(item.querySelector('.item-price').textContent.replace(/[^\d]/g, ''));
        const itemTotal = quantity * price;
        subtotal += itemTotal;
    });
    
    // Update subtotal and grand total
    document.getElementById('subtotal').textContent = `Rp ${formatNumber(subtotal)}`;
    document.getElementById('grand-total').textContent = `Rp ${formatNumber(subtotal)}`;
}

// Update cart counter in navbar
function updateCartCounter(count) {
    const cartCounter = document.querySelector('.cart-counter');
    if (cartCounter) {
        cartCounter.textContent = count;
        if (count === 0) {
            cartCounter.style.display = 'none';
        }
    }
}

// Format number with thousand separators
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Show notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#22c55e' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        z-index: 1000;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    `;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Add CSS for notification animation
const style = document.createElement('style');
style.textContent = `
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
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }
    
    .notification-close:hover {
        opacity: 1;
    }
`;
document.head.appendChild(style);
