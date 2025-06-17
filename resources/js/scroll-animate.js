document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk animasi saat scroll
    const animatedElements = document.querySelectorAll('.scroll-animate');

    if (animatedElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // Jika elemen masuk ke dalam viewport
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // (Opsional) Berhenti mengamati setelah animasi berjalan
                    // observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1 // Memicu animasi saat 10% elemen terlihat
        });

        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }
});
