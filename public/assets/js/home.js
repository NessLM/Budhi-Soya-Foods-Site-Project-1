document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.product-slide');
  const dots = document.querySelectorAll('.dot');
  const prev = document.querySelector('.prev');
  const next = document.querySelector('.next');
  const track = document.getElementById('slider-track');
  let currentIndex = 0;

  function showSlide(index) {
    track.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((dot, i) => {
      dot.classList.toggle('w-6', i === index);
      dot.classList.toggle('w-3', i !== index);
      dot.classList.toggle('bg-white', i === index);
      dot.classList.toggle('bg-white/60', i !== index);
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

  setInterval(() => {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }, 5000);

  showSlide(currentIndex);
});
