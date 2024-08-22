document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector('.testimonial-container');
    let scrollAmount = 0;
    const speed = 0.5; // Increased speed

    function slideTestimonials() {
        scrollAmount += speed;
        if (scrollAmount >= slider.scrollWidth / 3) {
            slider.appendChild(slider.firstElementChild);
            scrollAmount = 0;
            slider.style.transition = 'none';
            slider.style.transform = 'translateX(0)';
            setTimeout(() => {
                slider.style.transition = 'transform 0.5s ease';
            }, 50);
        } else {
            slider.style.transform = `translateX(-${scrollAmount}px)`;
        }
        requestAnimationFrame(slideTestimonials);
    }

    // Clone testimonials to make the infinite scroll effect
    const testimonials = document.querySelectorAll('.testimonial');
    for (let i = 0; i < testimonials.length; i++) {
        const clone = testimonials[i].cloneNode(true);
        slider.appendChild(clone);
    }

    slideTestimonials();

    // Improved fade-in effect
    const fadeElems = document.querySelectorAll('.fade-in');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    fadeElems.forEach(elem => observer.observe(elem));

    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
