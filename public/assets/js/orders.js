/**
 * Orders Page JavaScript
 * Handles order management functionality
 */

class OrdersManager {
    constructor() {
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // File upload preview
        const paymentProofInput = document.getElementById('payment_proof');
        if (paymentProofInput) {
            paymentProofInput.addEventListener('change', this.handleFileUpload.bind(this));
        }

        // QRIS modal functionality
        this.initializeQRISModal();
    }

    handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const previewImage = document.getElementById('preview-image');
                const filePreview = document.getElementById('file-preview');
                
                if (previewImage && filePreview) {
                    previewImage.src = e.target.result;
                    filePreview.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    }

    initializeQRISModal() {
        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            const modal = document.getElementById('qrisModal');
            if (event.target === modal) {
                this.closeQRISModal();
            }
        });
    }

    showQRISPayment() {
        const modal = document.getElementById('qrisModal');
        if (modal) {
            modal.style.display = 'block';
        }
    }

    closeQRISModal() {
        const modal = document.getElementById('qrisModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    confirmQRISPayment() {
        // Here you would integrate with actual QRIS payment gateway
        alert('Fitur QRIS akan diintegrasikan dengan payment gateway');
        this.closeQRISModal();
    }

    showManualTransfer() {
        const form = document.getElementById('manualTransferForm');
        if (form) {
            form.classList.remove('hidden');
        }
    }

    // Order cancellation confirmation
    confirmOrderCancellation(event) {
        return confirm('Yakin ingin membatalkan pesanan ini?');
    }

    // Order deletion confirmation
    confirmOrderDeletion(event) {
        return confirm('Yakin ingin menghapus pesanan ini dari tampilan? Data akan tetap tersimpan di log.');
    }

    // Show notification
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Loading state management
    setLoadingState(element, isLoading) {
        if (isLoading) {
            element.disabled = true;
            element.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        } else {
            element.disabled = false;
            element.innerHTML = element.getAttribute('data-original-text') || 'Submit';
        }
    }

    // Form validation
    validatePaymentForm() {
        const requiredFields = ['payment_proof', 'account_name', 'bank_name', 'transfer_amount'];
        let isValid = true;

        requiredFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value) {
                isValid = false;
                field.classList.add('border-red-500');
            } else if (field) {
                field.classList.remove('border-red-500');
            }
        });

        return isValid;
    }

    // Handle form submission
    handlePaymentFormSubmission(event) {
        if (!this.validatePaymentForm()) {
            event.preventDefault();
            this.showNotification('Mohon lengkapi semua field yang diperlukan', 'error');
            return false;
        }

        const submitBtn = event.target.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.setAttribute('data-original-text', submitBtn.innerHTML);
            this.setLoadingState(submitBtn, true);
        }

        return true;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.ordersManager = new OrdersManager();
});

// Global functions for inline HTML
function showQRISPayment() {
    if (window.ordersManager) {
        window.ordersManager.showQRISPayment();
    }
}

function closeQRISModal() {
    if (window.ordersManager) {
        window.ordersManager.closeQRISModal();
    }
}

function confirmQRISPayment() {
    if (window.ordersManager) {
        window.ordersManager.confirmQRISPayment();
    }
}

function showManualTransfer() {
    if (window.ordersManager) {
        window.ordersManager.showManualTransfer();
    }
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = OrdersManager;
} 