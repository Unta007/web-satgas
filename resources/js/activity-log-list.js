document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#activityLogTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Cari log...",
                lengthMenu: "Tampilkan _MENU_ log",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ log",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 log",
                infoFiltered: "(difilter dari _MAX_ total log)",
                zeroRecords: "Tidak ada aktivitas log yang ditemukan.",
                paginate: { first: "<<", last: ">>", next: ">", previous: "<" }
            },
            // Urutkan berdasarkan kolom Tanggal (index 1) lalu Waktu (index 0) secara descending
            order: [[1, 'desc'], [0, 'desc']],
            columnDefs: [
                // Jika ada kolom yang tidak ingin bisa di-sort
                // { "orderable": false, "targets": [/* index kolom */] }
            ]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat, tabel log tidak akan diinisialisasi.');
    }
});
