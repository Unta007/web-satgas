import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#usersTable').DataTable({ // GANTI ID
            responsive: true,
            language: { // GANTI TEKS
                searchPlaceholder: "Cari staff...",
                lengthMenu: "Tampilkan _MENU_ staff",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ staff",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 staff",
                infoFiltered: "(difilter dari _MAX_ total staff)",
                zeroRecords: "Staff tidak ditemukan",
                paginate: { first: "<<", last: ">>", next: ">", previous: "<" }
            },
            columnDefs: [ // Sesuaikan target kolom jika jumlah kolom berubah
                { "orderable": false, "targets": 6 } // Kolom Actions (ID, Nama, Username, Email, Role, Status, Actions -> index 6)
            ],
            order: [[0, "desc"]]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat.');
    }

    const deleteForms = document.querySelectorAll('.delete-user-form'); // GANTI CLASS
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Anda yakin ingin menghapus data staff ini? Tindakan ini tidak dapat diurungkan!", // GANTI TEKS
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
