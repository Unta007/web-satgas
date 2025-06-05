import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function() {
            const changePasswordForm = document.getElementById('changePasswordForm');

            if (changePasswordForm) {
                changePasswordForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah form submit secara otomatis

                    Swal.fire({
                        title: 'Konfirmasi Perubahan Password',
                        text: "Anda yakin ingin mengubah password Anda? Anda akan otomatis logout dan diminta untuk login kembali.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#A40E0E', // Warna tombol merah
                        cancelButtonColor: '#6c757d', // Warna tombol batal abu-abu
                        confirmButtonText: 'Ya, ubah password!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika dikonfirmasi, submit form secara programatik
                            event.target.submit();
                        }
                    });
                });
            }
        });
