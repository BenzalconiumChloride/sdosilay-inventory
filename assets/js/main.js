
  function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').classList.add('open');
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('open');
  }

  // Show hamburger on small screens
  function checkSize() {
    const hb = document.getElementById('hamburger');
    if (window.innerWidth <= 700) {
      hb.style.display = 'flex';
    } else {
      hb.style.display = 'none';
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('overlay').classList.remove('open');
    }
  }
  window.addEventListener('resize', checkSize);
  checkSize();

  // Nav item click
  document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function () {
      document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
      this.classList.add('active');
      if (window.innerWidth <= 700) closeSidebar();
    });
  });

  // Range buttons
  document.querySelectorAll('.range-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.range-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Period buttons
  document.querySelectorAll('.pill-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });