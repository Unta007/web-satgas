import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('statusSelect');
    const updateStatusForm = document.getElementById('updateStatusForm');

    if (statusSelect && updateStatusForm) {
        statusSelect.addEventListener('change', function (event) {
            const selectedStatus = this.value;
            const originalStatus = this.dataset.originalStatus;

            if (selectedStatus === originalStatus) {
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Perubahan Status',
                text: `Anda yakin ingin mengubah status laporan menjadi "${selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1)}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, ubah status!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatusForm.submit();
                } else {
                    this.value = originalStatus;
                }
            });
        });
    }
});
