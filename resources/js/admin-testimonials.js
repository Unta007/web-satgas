import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#testimonialsTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Cari testimoni...",
                lengthMenu: "Tampilkan _MENU_ testimoni",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ testimoni",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 testimoni",
                infoFiltered: "(difilter dari _MAX_ total testimoni)",
                zeroRecords: "Testimoni tidak ditemukan",
                paginate: { first: "<<", last: ">>", next: ">", previous: "<" }
            },
            columnDefs: [
                // DIUBAH: Nonaktifkan pengurutan untuk kolom Status & Aksi (indeks 2 & 3)
                { "orderable": false, "targets": [2, 3] }
            ],
            // DIUBAH: Urutkan berdasarkan kolom Tanggal Dibuat (sekarang indeks 1) secara descending
            order: [[1, "desc"]]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat, tabel tidak akan diinisialisasi.');
    }

    // Logika konfirmasi penghapusan (TIDAK PERLU DIUBAH)
    const deleteForms = document.querySelectorAll('.delete-testimonial-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Anda yakin ingin menghapus testimoni ini? Tindakan ini tidak dapat diurungkan!",
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
