import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

document.addEventListener('DOMContentLoaded', function () {
    // Cek jika jQuery & DataTables sudah dimuat
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#emergencyContactsTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Cari kontak...",
                lengthMenu: "Tampilkan _MENU_ kontak",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ kontak",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 kontak",
                infoFiltered: "(difilter dari _MAX_ total kontak)",
                zeroRecords: "Kontak darurat tidak ditemukan",
                paginate: { first: "<<", last: ">>", next: ">", previous: "<" }
            },
            columnDefs: [
                // Nonaktifkan pengurutan untuk kolom Aksi (indeks 5)
                { "orderable": false, "targets": 5 }
            ],
            // Urutkan berdasarkan kolom Urutan (indeks 0) secara ascending
            order: [[0, "asc"]]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat, tabel tidak akan diinisialisasi.');
    }

    // Logika konfirmasi penghapusan menggunakan SweetAlert
    const deleteForms = document.querySelectorAll('.delete-contact-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Anda yakin ingin menghapus kontak ini? Tindakan ini tidak dapat diurungkan!",
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
