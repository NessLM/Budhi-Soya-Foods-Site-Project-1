// Navbar scroll effect
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const body = document.body;
    let lastScrollTop = 0;
    let ticking = false;

    function updateNavbar() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 50) {
            navbar.classList.add('scrolled');
            body.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('scrolled');
            body.classList.remove('navbar-scrolled');
        }

        lastScrollTop = scrollTop;
        ticking = false;
    }

    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    }

    // Listen for scroll events
    window.addEventListener('scroll', requestTick, { passive: true });

    // Mobile menu toggle functionality
    const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navbar.classList.toggle('active');
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!navbar.contains(event.target)) {
                    navbar.classList.remove('active');
                }
            });
        });
    }

    // Handle mobile dropdown clicks
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const dropbtn = dropdown.querySelector('.dropbtn');
        if (dropbtn && window.innerWidth <= 768) {
            dropbtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            });
        }
    });

    // Close mobile menu when window is resized
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            navbar.classList.remove('active');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - navbar.offsetHeight;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add transition class during scroll
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        body.classList.add('navbar-transitioning');
        
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            body.classList.remove('navbar-transitioning');
        }, 150);
    }, { passive: true });
});