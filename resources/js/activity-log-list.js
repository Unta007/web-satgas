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
            order: [[1, 'desc'], [0, 'desc']],
            columnDefs: [
            ]
        });
    } else {
        console.warn('jQuery atau DataTables belum dimuat, tabel log tidak akan diinisialisasi.');
    }
});
