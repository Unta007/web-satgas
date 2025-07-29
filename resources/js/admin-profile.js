import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function() {
            const changePasswordForm = document.getElementById('changePasswordForm');

            if (changePasswordForm) {
                changePasswordForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Konfirmasi Perubahan Password',
                        text: "Anda yakin ingin mengubah password Anda? Anda akan otomatis logout dan diminta untuk login kembali.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#A40E0E',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, ubah password!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            event.target.submit();
                        }
                    });
                });
            }
        });
