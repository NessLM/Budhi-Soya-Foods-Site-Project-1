// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    const body = document.body;
    
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
        body.classList.add('navbar-scrolled');
    } else {
        navbar.classList.remove('scrolled');
        body.classList.remove('navbar-scrolled');
    }
});

// Mobile menu toggle with improved animation
function toggleMobileMenu() {
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('active');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const navbar = document.querySelector('.navbar');
    const menuToggle = document.querySelector('.menu-toggle');
    
    if (navbar && menuToggle && !navbar.contains(event.target) && !menuToggle.contains(event.target)) {
        navbar.classList.remove('active');
    }
});

// Close mobile menu when clicking on nav links
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.navbar .nav-links a, .navbar .btnaccount a');
    const navbar = document.querySelector('.navbar');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (navbar) {
                navbar.classList.remove('active');
            }
        });
    });
});

// Smooth scroll for anchor links
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

// Add navbar-body class to body for proper spacing
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('navbar-body');
});

// Login Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const loginModal = document.getElementById('loginModal');
    const closeModal = document.querySelector('.close-modal');
    
    // Function to show login modal
    function showLoginModal() {
        if (loginModal) {
            loginModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    }
    
    // Function to hide login modal and restore scrolling
    function hideLoginModal() {
        if (loginModal) {
            loginModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    }
    
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
    
    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && loginModal && loginModal.style.display === 'flex') {
            hideLoginModal();
        }
    });
    
    // Handle modal button clicks to restore scrolling
    const modalButtons = document.querySelectorAll('.modal-login-btn, .modal-register-btn');
    modalButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Restore scrolling when navigating away
            document.body.style.overflow = 'auto';
            hideLoginModal(); // Also hide the modal
        });
    });
});
