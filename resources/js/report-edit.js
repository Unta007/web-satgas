import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('statusSelect');
    const updateStatusForm = document.getElementById('updateStatusForm');
    const hiddenRejectionNoteInput = document.getElementById('hiddenRejectionNote');

    if (statusSelect && updateStatusForm) {
        // Simpan status awal saat halaman dimuat
        let originalStatus = statusSelect.dataset.originalStatus;

        statusSelect.addEventListener('change', function () {
            const newStatus = this.value;

            // Jika status tidak berubah, batalkan dan kembalikan ke status awal
            if (newStatus === originalStatus) {
                return;
            }

            // Jika status yang dipilih adalah 'denied'
            if (newStatus === 'denied') {
                showDeniedConfirmation(newStatus);
            } else { // Untuk semua status lainnya
                showGenericConfirmation(newStatus);
            }
        });

        // Fungsi untuk menampilkan popup konfirmasi biasa
        function showGenericConfirmation(status) {
            Swal.fire({
                title: `Ubah Status?`,
                text: `Anda yakin ingin mengubah status laporan menjadi "${capitalizeFirstLetter(status)}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah Status!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, langsung submit form
                    updateStatusForm.submit();
                } else {
                    // Jika dibatalkan, kembalikan pilihan dropdown ke status awal
                    statusSelect.value = originalStatus;
                }
            });
        }

        // Fungsi untuk menampilkan popup khusus saat status 'denied'
        function showDeniedConfirmation(status) {
            Swal.fire({
                title: 'Tolak Laporan?',
                icon: 'warning',
                html: `
                    <p class="text-start mb-4">Harap berikan alasan penolakan di bawah ini. Catatan ini akan dapat dilihat oleh pelapor.</p>
                    <textarea id="swalRejectionNote" class="form-control" rows="5" placeholder="Contoh: Bukti yang dilampirkan tidak cukup untuk melanjutkan proses investigasi."></textarea>
                `,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Tolak Laporan!',
                cancelButtonText: 'Batal',
                // Validasi sebelum konfirmasi
                preConfirm: () => {
                    const note = document.getElementById('swalRejectionNote').value;
                    if (!note || note.trim() === '') {
                        Swal.showValidationMessage('Catatan penolakan wajib diisi.');
                        return false;
                    }
                    return note; // Kembalikan nilai catatan jika valid
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // 'result.value' berisi catatan dari preConfirm
                    const rejectionNote = result.value;
                    // Isi input tersembunyi dengan catatan dari popup
                    hiddenRejectionNoteInput.value = rejectionNote;
                    // Kirim form
                    updateStatusForm.submit();
                } else {
                    // Jika dibatalkan, kembalikan pilihan dropdown ke status awal
                    statusSelect.value = originalStatus;
                }
            });
        }
    }

    // Helper function untuk membuat huruf pertama kapital
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
