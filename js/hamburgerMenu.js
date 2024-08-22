// hamburgerMenu.js
document.addEventListener('DOMContentLoaded', function() {
  const hamburger = document.querySelector('.hamburger');
  const navbar = document.querySelector('.navbar');

  hamburger.addEventListener('click', function() {
    this.classList.toggle('active');
    navbar.classList.toggle('active');
  });

  // Handle the action buttons and nav-items positioning
  const handleLayout = () => {
    const actionButtons = document.querySelector('.action-buttons');
    const navItems = document.querySelector('.nav-items');

    if (actionButtons && navItems) {
      if (actionButtons.querySelector('a')) {
        navItems.style.justifyContent = 'center';
        actionButtons.style.justifyContent = 'flex-end';
      } else {
        navItems.style.justifyContent = 'flex-end';
        actionButtons.style.display = 'none';
      }
    }
  };

  handleLayout(); // Initial layout handling

  // Optional: Adjust layout if action buttons are dynamically added/removed
  const observer = new MutationObserver(handleLayout);
  observer.observe(document.querySelector('.action-buttons'), { childList: true });

  // Smooth scrolling
  const navLinks = document.querySelectorAll('.nav-items a');
  navLinks.forEach(link => {
    link.addEventListener('click', (event) => {
      const targetId = event.target.getAttribute('href');
      const targetElement = document.querySelector(targetId);

      if (targetElement) {
        event.preventDefault();
        targetElement.scrollIntoView({ behavior: 'smooth' });
        hamburger.classList.remove('active');
        navbar.classList.remove('active');
      }
    });
  });
});
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-items a');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                event.preventDefault();
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
