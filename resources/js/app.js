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
});
