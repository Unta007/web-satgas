import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#articlesTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Cari artikel...",
                lengthMenu: "Tampilkan _MENU_ artikel",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ artikel",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 artikel",
                infoFiltered: "(difilter dari _MAX_ total artikel)",
                zeroRecords: "Artikel tidak ditemukan",
                paginate: { first: "<<", last: ">>", next: ">", previous: "<" }
            },
            columnDefs: [
                { "orderable": false, "targets": 3 }
            ],
            order: [[2, "desc"]]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat, tabel tidak akan diinisialisasi.');
    }

    const deleteForms = document.querySelectorAll('.delete-article-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat diurungkan!",
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
