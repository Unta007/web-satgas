document.addEventListener('DOMContentLoaded', () => {
    const loadMoreContainer = document.getElementById('load-more-container');
    if (!loadMoreContainer) return;

    const loadMoreBtn = document.getElementById('load-more-btn');
    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener('click', () => {
        let nextPageUrl = loadMoreBtn.getAttribute('data-next-page');
        if (!nextPageUrl) return;

        // Tampilkan loading (opsional)
        loadMoreBtn.textContent = 'Memuat...';
        loadMoreBtn.disabled = true;

        fetch(nextPageUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Penting agar request terdeteksi sebagai AJAX di Laravel
            },
        })
        .then(response => response.json())
        .then(data => {
            // Tambahkan HTML baru ke dalam container
            const articleContainer = document.getElementById('article-list-container');
            articleContainer.insertAdjacentHTML('beforeend', data.html);

            // Perbarui URL untuk halaman berikutnya atau sembunyikan tombol
            if (data.next_page_url) {
                loadMoreBtn.setAttribute('data-next-page', data.next_page_url);

                // Kembalikan tombol ke state normal
                loadMoreBtn.textContent = 'Muat Lebih Banyak';
                loadMoreBtn.disabled = false;
            } else {
                // Sembunyikan tombol jika sudah tidak ada halaman lagi
                loadMoreContainer.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error loading more articles:', error);
            loadMoreBtn.textContent = 'Gagal Memuat. Coba Lagi';
            loadMoreBtn.disabled = false;
        });
    });
});
