
// Contact page JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
    initializeFAQ();
});

// Form Handling
function initializeForm() {
    const form = document.getElementById('contactForm');
    const submitBtn = form.querySelector('.submit-btn');
    const loadingSpinner = submitBtn.querySelector('.loading-spinner');
    const submitText = submitBtn.querySelector('span');

    // Form validation
    const validators = {
        firstName: {
            required: true,
            minLength: 2,
            pattern: /^[a-zA-Z\s]+$/,
            message: 'Nama depan harus berisi minimal 2 karakter dan hanya huruf'
        },
        lastName: {
            required: true,
            minLength: 2,
            pattern: /^[a-zA-Z\s]+$/,
            message: 'Nama belakang harus berisi minimal 2 karakter dan hanya huruf'
        },
        email: {
            required: true,
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            message: 'Format email tidak valid'
        },
        phone: {
            required: true,
            pattern: /^[\+]?[0-9]{10,15}$/,
            message: 'Nomor telepon harus berisi 10-15 digit'
        },
        subject: {
            required: true,
            message: 'Silakan pilih subjek'
        },
        message: {
            required: true,
            minLength: 10,
            message: 'Pesan harus berisi minimal 10 karakter'
        },
        privacy: {
            required: true,
            message: 'Anda harus menyetujui kebijakan privasi'
        }
    };

    // Real-time validation
    Object.keys(validators).forEach(fieldName => {
        const field = document.getElementById(fieldName);
        const errorElement = document.getElementById(fieldName + 'Error');

        if (field && errorElement) {
            field.addEventListener('blur', () => validateField(fieldName, field, errorElement, validators[fieldName]));
            field.addEventListener('input', () => clearError(errorElement));
        }
    });

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate all fields
        let isValid = true;
        Object.keys(validators).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            const errorElement = document.getElementById(fieldName + 'Error');
            
            if (field && errorElement) {
                if (!validateField(fieldName, field, errorElement, validators[fieldName])) {
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            // Scroll to first error
            const firstError = form.querySelector('.error-message.show');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.style.display = 'block';
        submitText.textContent = 'Mengirim...';

        // Simulate form submission (replace with actual submission logic)
        try {
            await simulateFormSubmission();
            
            // Show success modal
            showSuccessModal();
            
            // Reset form
            form.reset();
            
        } catch (error) {
            console.error('Error submitting form:', error);
            alert('Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            loadingSpinner.style.display = 'none';
            submitText.textContent = 'Kirim Pesan';
        }
    });
}

function validateField(fieldName, field, errorElement, validator) {
    const value = field.type === 'checkbox' ? field.checked : field.value.trim();
    
    // Required validation
    if (validator.required && (!value || value === '')) {
        showError(errorElement, validator.message || `${fieldName} wajib diisi`);
        return false;
    }
    
    // Skip other validations if field is empty and not required
    if (!value && !validator.required) {
        clearError(errorElement);
        return true;
    }
    
    // Minimum length validation
    if (validator.minLength && value.length < validator.minLength) {
        showError(errorElement, validator.message || `Minimal ${validator.minLength} karakter`);
        return false;
    }
    
    // Pattern validation
    if (validator.pattern && !validator.pattern.test(value)) {
        showError(errorElement, validator.message || 'Format tidak valid');
        return false;
    }
    
    clearError(errorElement);
    return true;
}

function showError(errorElement, message) {
    errorElement.textContent = message;
    errorElement.classList.add('show');
}

function clearError(errorElement) {
    errorElement.textContent = '';
    errorElement.classList.remove('show');
}

async function simulateFormSubmission() {
    // Simulate network delay
    return new Promise((resolve) => {
        setTimeout(resolve, 2000);
    });
}

function showSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// FAQ Functionality
function initializeFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        question.addEventListener('click', () => {
            const isActive = question.classList.contains('active');
            
            // Close all other FAQ items
            faqItems.forEach(otherItem => {
                const otherQuestion = otherItem.querySelector('.faq-question');
                const otherAnswer = otherItem.querySelector('.faq-answer');
                
                if (otherItem !== item) {
                    otherQuestion.classList.remove('active');
                    otherAnswer.classList.remove('show');
                }
            });
            
            // Toggle current item
            if (isActive) {
                question.classList.remove('active');
                answer.classList.remove('show');
            } else {
                question.classList.add('active');
                answer.classList.add('show');
            }
        });
    });
}

function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const question = faqItem.querySelector('.faq-question');
    const answer = faqItem.querySelector('.faq-answer');
    
    const isActive = question.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        const q = item.querySelector('.faq-question');
        const a = item.querySelector('.faq-answer');
        q.classList.remove('active');
        a.classList.remove('show');
    });
    
    // Toggle current item
    if (!isActive) {
        question.classList.add('active');
        answer.classList.add('show');
    }
}

// Map functionality
function showMap() {
    const mapPlaceholder = document.getElementById('mapPlaceholder');
    mapPlaceholder.scrollIntoView({ behavior: 'smooth' });
}

function openGoogleMaps() {
    const address = 'Jl. Contoh No. 123, Kota, Provinsi';
    const encodedAddress = encodeURIComponent(address);
    const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`;
    window.open(googleMapsUrl, '_blank');
}

// Smooth scrolling for internal links
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

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('successModal');
    if (event.target === modal) {
        closeModal();
    }
});

// Keyboard accessibility for modal
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Form field character counter (optional enhancement)
function addCharacterCounter(fieldId, maxLength) {
    const field = document.getElementById(fieldId);
    const counter = document.createElement('div');
    counter.className = 'character-counter';
    counter.style.cssText = 'font-size: 0.8rem; color: #6c757d; text-align: right; margin-top: 0.5rem;';
    
    field.parentElement.appendChild(counter);
    
    function updateCounter() {
        const currentLength = field.value.length;
        counter.textContent = `${currentLength}/${maxLength}`;
        
        if (currentLength > maxLength * 0.9) {
            counter.style.color = '#ef4444';
        } else if (currentLength > maxLength * 0.7) {
            counter.style.color = '#f59e0b';
        } else {
            counter.style.color = '#6c757d';
        }
    }
    
    field.addEventListener('input', updateCounter);
    updateCounter();
}

// Initialize character counters for textarea
addCharacterCounter('message', 500);

// Auto-resize textarea
function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

const messageTextarea = document.getElementById('message');
if (messageTextarea) {
    messageTextarea.addEventListener('input', function() {
        autoResizeTextarea(this);
    });
}

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in-up');
        }
    });
}, observerOptions);

// Observe elements for animation
document.querySelectorAll('.method-card, .faq-item, .info-card').forEach(el => {
    observer.observe(el);
});
