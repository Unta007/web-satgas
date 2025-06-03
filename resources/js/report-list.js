import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi DataTables (jika belum ada di sini)
    if (typeof $ !== 'undefined' && $.fn.DataTable) { // Pastikan jQuery dan DataTable ada
        $('#ReportsTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Cari laporan...",
                lengthMenu: "Tampilkan _MENU_ laporan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ laporan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 laporan",
                infoFiltered: "(difilter dari _MAX_ total laporan)",
                zeroRecords: "Data tidak ditemukan",
                paginate: { first: "<<", last: ">>", next: ">", previous: "<" }
            },
            columnDefs: [{ "orderable": false, "targets": 6, "width": "10%" }],
            order: [[1, "asc"]]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat, tabel tidak akan diinisialisasi.');
    }

    // Konfirmasi Penghapusan
    const deleteForms = document.querySelectorAll('.delete-report-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat diurungkan!",
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
