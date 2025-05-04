import "./bootstrap";
import.meta.glob(["../images/**"]);

document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('testimonialSlider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.slide');
    let currentIndex = 0;
    const totalSlides = slides.length;

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.classList.remove('active');
            if (index === currentIndex) {
                slide.classList.add('active');
            }
        });
        const sliderWrapper = slider.querySelector('.slider-wrapper');
        sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    function showNext() {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateSlider();
    }

    // Auto slide every 5 seconds
    const autoSlideInterval = setInterval(() => {
        showNext();
    }, 5000);

    // Initialize slider
    updateSlider();

    // Fade-in on scroll for sections
    const faders = document.querySelectorAll('.fade-in-section');

    const appearOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                return;
            } else {
                entry.target.classList.add('is-visible');
                appearOnScroll.unobserve(entry.target);
            }
        });
    }, appearOptions);

    faders.forEach(fader => {
        appearOnScroll.observe(fader);
    });

    // Back to top button
    const backToTopBtn = document.getElementById('backToTopBtn');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
