import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

function toggleWitnessFields(show) {
    const fields = document.getElementById('witness_fields');
    if (fields) fields.style.display = show ? 'block' : 'none';
}

function togglePerpetratorFields(show) {
    const fields = document.getElementById('perpetrator_fields');
    if (fields) fields.style.display = show ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => {

    const flashMessageEl = document.getElementById('flash-message');

    if (flashMessageEl) {
        const message = flashMessageEl.dataset.message;
        const type = flashMessageEl.dataset.type;
        const redirectUrl = flashMessageEl.dataset.redirectUrl;

        let title = '';
        if (type === 'success') {
            title = 'Berhasil!';
        } else if (type === 'error') {
            title = 'Oops... Terjadi Kesalahan';
        }

        const swalOptions = {
            title: title,
            text: message,
            icon: type,
            confirmButtonColor: '#A40E0E',
        };

        if (type === 'success' && redirectUrl) {
            swalOptions.showCancelButton = true;
            swalOptions.confirmButtonText = 'Lihat Laporan Saya';
            swalOptions.cancelButtonText = 'OK';
            swalOptions.cancelButtonColor = '#6c757d';

            Swal.fire(swalOptions).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = redirectUrl;
                }
            });

        } else {
            swalOptions.confirmButtonText = 'OK';
            Swal.fire(swalOptions);
        }
    }

    const reportForm = document.getElementById('report-form');
    if (reportForm) {
        reportForm.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                text: "Apakah Anda yakin semua data yang diisi sudah benar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#A40E0E',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim Laporan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }

    const witnessRadios = document.querySelectorAll('input[name="has_witness"]');
    witnessRadios.forEach(radio => {
        radio.addEventListener('change', (event) => toggleWitnessFields(event.target.value === 'yes'));
    });
    if (document.querySelector('input[name="has_witness"]:checked')) {
        toggleWitnessFields(document.querySelector('input[name="has_witness"]:checked').value === 'yes');
    }

    const perpetratorRadios = document.querySelectorAll('input[name="knows_perpetrator"]');
    perpetratorRadios.forEach(radio => {
        radio.addEventListener('change', (event) => togglePerpetratorFields(event.target.value === 'yes'));
    });
    if (document.querySelector('input[name="knows_perpetrator"]:checked')) {
        togglePerpetratorFields(document.querySelector('input[name="knows_perpetrator"]:checked').value === 'yes');
    }

    const fileInput = document.getElementById('evidence');
    if (fileInput) {
        const fileNameSpan = document.querySelector('.file-upload-wrapper .file-name');
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileNameSpan.textContent = `File terpilih: ${e.target.files[0].name}`;
            } else {
                fileNameSpan.textContent = '';
            }
        });
    }

});
