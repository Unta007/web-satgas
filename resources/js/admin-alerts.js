import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
const messagesDiv = document.getElementById('laravelSessionMessages');

    if (messagesDiv) {
        const successMessage = messagesDiv.dataset.successMessage;
        const errorMessage = messagesDiv.dataset.errorMessage;
        const warningMessage = messagesDiv.dataset.warningMessage;
        const infoMessage = messagesDiv.dataset.infoMessage;

        if (successMessage) {
            Swal.fire({
                title: 'Berhasil!',
                text: successMessage,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }

        if (errorMessage) {
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        }

        if (warningMessage) {
            Swal.fire({
                title: 'Peringatan!',
                text: warningMessage,
                icon: 'warning',
                confirmButtonColor: '#ffc107', // Bootstrap warning color
                confirmButtonText: 'OK'
            });
        }

        if (infoMessage) {
            Swal.fire({
                title: 'Informasi',
                text: infoMessage,
                icon: 'info',
                confirmButtonColor: '#0dcaf0', // Bootstrap info color
                confirmButtonText: 'OK'
            });
        }
    }
});
