// LOGIN PAGE

// Menunggu hingga seluruh halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Mengubah tipe input dari password ke text atau sebaliknya
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Mengubah ikon mata
        this.classList.toggle('bi-eye-slash-fill');
        this.classList.toggle('bi-eye-fill');
    });
});
