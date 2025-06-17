document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.profile-nav a');
    const contentSections = document.querySelectorAll('.profile-content-section');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            navLinks.forEach(nav => nav.classList.remove('is-active'));
            contentSections.forEach(section => section.classList.remove('is-active'));

            this.classList.add('is-active');

            const targetId = this.getAttribute('data-target');
            document.querySelector(targetId).classList.add('is-active');

            window.location.hash = targetId;
        });
    });

    if (window.location.hash) {
        const activeLink = document.querySelector(`.profile-nav a[data-target="${window.location.hash}"]`);
        if (activeLink) {
            activeLink.click();
        }
    }

    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const originalPhotoUrl = photoPreview.src;

    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {

                photoPreview.src = originalPhotoUrl;
            }
        });
    }
});
