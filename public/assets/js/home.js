document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.product-card');
    const dots = document.querySelectorAll('.dot');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    let currentIndex = 0;
  
    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.style.transform = `translateX(-${index * 100}%)`;
        dots[i].classList.toggle('active', i === index);
      });
    }
  
    prev.addEventListener('click', () => {
      currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
      showSlide(currentIndex);
    });
  
    next.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    });
  
    // Auto-scroll
    setInterval(() => {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    }, 5000); // Ganti slide setiap 5 detik
  });
  