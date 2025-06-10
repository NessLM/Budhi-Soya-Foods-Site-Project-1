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
    
    if (!navbar.contains(event.target) && !menuToggle.contains(event.target)) {
        navbar.classList.remove('active');
    }
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