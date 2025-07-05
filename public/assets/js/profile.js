// Profile Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeProfileTabs();
    initializeFormValidation();
    initializeAddressForm();
    initializeAlerts();
});

// Tab Navigation
function initializeProfileTabs() {
    const navItems = document.querySelectorAll('.nav-item');
    const tabContents = document.querySelectorAll('.tab-content');

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all nav items and tab contents
            navItems.forEach(nav => nav.classList.remove('active'));
            tabContents.forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked nav item and corresponding tab
            this.classList.add('active');
            const targetTabContent = document.getElementById(targetTab);
            if (targetTabContent) {
                targetTabContent.classList.add('active');
            }
            
            // Update URL hash without scrolling
            history.replaceState(null, null, '#' + targetTab);
        });
    });

    // Handle initial tab based on URL hash
    const hash = window.location.hash.substring(1);
    if (hash) {
        const targetNavItem = document.querySelector(`[data-tab="${hash}"]`);
        if (targetNavItem) {
            targetNavItem.click();
        }
    }
}

// Form Validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('.profile-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    // Special validation for password confirmation
    const newPassword = form.querySelector('input[name="new_password"]');
    const confirmPassword = form.querySelector('input[name="new_password_confirmation"]');
    
    if (newPassword && confirmPassword) {
        if (newPassword.value !== confirmPassword.value) {
            showFieldError(confirmPassword, 'Password konfirmasi tidak sesuai');
            isValid = false;
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name');
    
    // Clear previous errors
    clearFieldError(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Format email tidak valid');
            return false;
        }
    }
    
    // Phone validation
    if (fieldName === 'phone' && value) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        if (!phoneRegex.test(value)) {
            showFieldError(field, 'Format nomor telepon tidak valid');
            return false;
        }
    }
    
    // Password validation
    if (fieldName === 'new_password' && value) {
        if (value.length < 8) {
            showFieldError(field, 'Password minimal 8 karakter');
            return false;
        }
    }
    
    return true;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.style.borderColor = '#ef4444';
    field.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
    
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.style.cssText = `
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    `;
    errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    
    field.parentNode.appendChild(errorElement);
}

function clearFieldError(field) {
    field.style.borderColor = '';
    field.style.boxShadow = '';
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Address Form Management
function initializeAddressForm() {
    // Initialize form toggle
    window.toggleAddressForm = function() {
        const form = document.getElementById('add-address-form');
        const isVisible = form.style.display !== 'none';
        
        if (isVisible) {
            form.style.display = 'none';
            form.querySelector('form').reset();
            clearAllFieldErrors(form);
        } else {
            form.style.display = 'block';
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Focus on first input
            const firstInput = form.querySelector('input');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 300);
            }
        }
    };
    
    // Auto-format postal code
    const postalCodeInput = document.querySelector('input[name="postal_code"]');
    if (postalCodeInput) {
        postalCodeInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 5);
        });
    }
    
    // Auto-format phone number
    const phoneInputs = document.querySelectorAll('input[name="phone"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            } else if (!value.startsWith('+62')) {
                value = '+62' + value;
            }
            this.value = value;
        });
    });
}

function clearAllFieldErrors(container) {
    const errors = container.querySelectorAll('.field-error');
    errors.forEach(error => error.remove());
    
    const inputs = container.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.style.borderColor = '';
        input.style.boxShadow = '';
    });
}

// Alert Management
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Auto-hide success alerts after 5 seconds
        if (alert.classList.contains('alert-success')) {
            setTimeout(() => {
                hideAlert(alert);
            }, 5000);
        }
        
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '<i class="fas fa-times"></i>';
        closeBtn.className = 'alert-close';
        closeBtn.style.cssText = `
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            margin-left: auto;
            padding: 0.25rem;
            border-radius: 4px;
            transition: background-color 0.2s;
        `;
        
        closeBtn.addEventListener('click', () => hideAlert(alert));
        closeBtn.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(0,0,0,0.1)';
        });
        closeBtn.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
        });
        
        alert.appendChild(closeBtn);
    });
}

function hideAlert(alert) {
    alert.style.transition = 'all 0.3s ease';
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    
    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 300);
}

// Utility Functions
function showLoading(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    button.disabled = true;
    
    return function hideLoading() {
        button.innerHTML = originalText;
        button.disabled = false;
    };
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Enhanced form submission with loading states
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.classList.contains('profile-form')) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const hideLoading = showLoading(submitBtn);
            
            // Hide loading after form submission (whether success or error)
            setTimeout(hideLoading, 2000);
        }
    }
});

// Smooth scrolling for navigation
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Keyboard navigation support
document.addEventListener('keydown', function(e) {
    // ESC key to close address form
    if (e.key === 'Escape') {
        const addressForm = document.getElementById('add-address-form');
        if (addressForm && addressForm.style.display !== 'none') {
            toggleAddressForm();
        }
    }
    
    // Tab navigation with arrow keys
    if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
        const activeNavItem = document.querySelector('.nav-item.active');
        if (activeNavItem && document.activeElement === activeNavItem) {
            e.preventDefault();
            const navItems = Array.from(document.querySelectorAll('.nav-item'));
            const currentIndex = navItems.indexOf(activeNavItem);
            
            let nextIndex;
            if (e.key === 'ArrowLeft') {
                nextIndex = currentIndex > 0 ? currentIndex - 1 : navItems.length - 1;
            } else {
                nextIndex = currentIndex < navItems.length - 1 ? currentIndex + 1 : 0;
            }
            
            navItems[nextIndex].click();
            navItems[nextIndex].focus();
        }
    }
});

// Auto-save draft functionality (optional enhancement)
function initializeAutoSave() {
    const forms = document.querySelectorAll('.profile-form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('input', debounce(function() {
                saveFormDraft(form);
            }, 1000));
        });
        
        // Load saved draft on page load
        loadFormDraft(form);
    });
}

function saveFormDraft(form) {
    const formData = new FormData(form);
    const draftData = {};
    
    for (let [key, value] of formData.entries()) {
        draftData[key] = value;
    }
    
    const formId = form.id || form.className;
    localStorage.setItem(`profile_draft_${formId}`, JSON.stringify(draftData));
}

function loadFormDraft(form) {
    const formId = form.id || form.className;
    const savedDraft = localStorage.getItem(`profile_draft_${formId}`);
    
    if (savedDraft) {
        try {
            const draftData = JSON.parse(savedDraft);
            
            Object.keys(draftData).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input && input.type !== 'password') {
                    input.value = draftData[key];
                }
            });
        } catch (e) {
            console.warn('Failed to load form draft:', e);
        }
    }
}

function clearFormDraft(form) {
    const formId = form.id || form.className;
    localStorage.removeItem(`profile_draft_${formId}`);
}

// Debounce utility function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize auto-save if needed
// initializeAutoSave();

// Export functions for global access
window.ProfileJS = {
    toggleAddressForm,
    showLoading,
    confirmAction,
    smoothScrollTo,
    hideAlert
};