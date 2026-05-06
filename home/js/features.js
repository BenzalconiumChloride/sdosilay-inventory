const carousel = document.querySelector('.image-carousel');
  const cards = document.querySelectorAll('.image-frame');
  const dots = document.querySelectorAll('.swipe-dot');
  let currentIndex = 0;
  let startX = 0;
  let isDragging = false;

  function updateCarousel() {
      cards.forEach((card, index) => {
          card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
          
          const position = (index - currentIndex + cards.length) % cards.length;
          
          if (position === 0) {
              card.style.transform = 'translateY(0) scale(1)';
              card.style.zIndex = 3;
              card.style.opacity = 1;
          } else if (position === 1) {
              card.style.transform = 'translateY(15px) scale(0.95)';
              card.style.zIndex = 2;
              card.style.opacity = 0.7;
          } else {
              card.style.transform = 'translateY(30px) scale(0.9)';
              card.style.zIndex = 1;
              card.style.opacity = 0.5;
          }
      });

      dots.forEach((dot, index) => {
          dot.classList.toggle('active', index === currentIndex);
      });
  }

  function nextCard() {
      currentIndex = (currentIndex + 1) % cards.length;
      updateCarousel();
  }

  function prevCard() {
      currentIndex = (currentIndex - 1 + cards.length) % cards.length;
      updateCarousel();
  }

  // Touch and mouse events
  carousel.addEventListener('mousedown', (e) => {
      isDragging = true;
      startX = e.pageX;
      cards[currentIndex].style.transition = 'none';
  });

  carousel.addEventListener('touchstart', (e) => {
      isDragging = true;
      startX = e.touches[0].pageX;
      cards[currentIndex].style.transition = 'none';
  });

  carousel.addEventListener('mousemove', (e) => {
      if (!isDragging) return;
      const currentX = e.pageX;
      const diff = currentX - startX;
      cards[currentIndex].style.transform = `translateX(${diff}px) rotate(${diff * 0.1}deg)`;
  });

  carousel.addEventListener('touchmove', (e) => {
      if (!isDragging) return;
      const currentX = e.touches[0].pageX;
      const diff = currentX - startX;
      cards[currentIndex].style.transform = `translateX(${diff}px) rotate(${diff * 0.1}deg)`;
  });

  function handleDragEnd(endX) {
      if (!isDragging) return;
      isDragging = false;
      
      const diff = endX - startX;
      const threshold = 100;

      if (diff > threshold) {
          prevCard();
      } else if (diff < -threshold) {
          nextCard();
      } else {
          cards[currentIndex].style.transition = 'all 0.3s ease';
          cards[currentIndex].style.transform = 'translateY(0) scale(1)';
      }
  }

  carousel.addEventListener('mouseup', (e) => handleDragEnd(e.pageX));
  carousel.addEventListener('mouseleave', (e) => {
      if (isDragging) handleDragEnd(e.pageX);
  });
  carousel.addEventListener('touchend', (e) => handleDragEnd(e.changedTouches[0].pageX));

  // Click on dots to navigate
  dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
          currentIndex = index;
          updateCarousel();
      });
  });

  // Auto-play (optional)
  setInterval(nextCard, 5000);