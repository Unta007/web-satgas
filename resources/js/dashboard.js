/**
 * Fungsi untuk mencari elemen canvas, mengambil datanya, dan membuat grafik.
 * @param {string} canvasId ID dari elemen <canvas>
 * @param {string} chartType Tipe grafik ('line', 'doughnut', dll.)
 * @param {object} chartOptions Opsi kustom untuk Chart.js
 */
function initializeChart(canvasId, chartType, chartOptions = {}) {
    const canvas = document.getElementById(canvasId);

    // Berhenti jika elemen canvas tidak ditemukan di halaman
    if (!canvas) {
        return;
    }

    // Ambil string JSON dari atribut 'data-chart-data'
    const dataString = canvas.dataset.chartData;
    if (!dataString) {
        console.error(`Data attribute not found for chart: ${canvasId}`);
        return;
    }

    // Ubah string JSON menjadi objek/array JavaScript
    const chartData = JSON.parse(dataString);

    let dataConfig;
    const chartColors = ['#0d6efd', '#198754', '#ffc107', '#838383', '#dc3545']; 

    // Konfigurasi data berdasarkan tipe grafik
    if (chartType === 'line') {
        dataConfig = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Laporan',
                data: chartData,
                borderColor: 'rgba(15, 15, 15, 0.64)',
                backgroundColor: 'rgba(0, 0, 0, 0.09)',
                fill: true,
                tension: 0.3
            }]
        };
    } else if (chartType === 'doughnut') {
        dataConfig = {
            labels: Object.keys(chartData),
            datasets: [{
                data: Object.values(chartData),
                backgroundColor: chartColors,
                hoverOffset: 4
            }]
        };
    }

    // Buat grafik baru
    new Chart(canvas.getContext('2d'), {
        type: chartType,
        data: dataConfig,
        options: chartOptions,
    });
}

// Jalankan semua inisialisasi setelah seluruh halaman HTML dimuat
document.addEventListener('DOMContentLoaded', () => {
    initializeChart('reportByMonthChart', 'line', {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                // TAMBAHKAN BLOK INI
                ticks: {
                    precision: 0, // Memastikan tidak ada angka desimal
                    callback: function (value) {
                        // Hanya tampilkan label jika nilainya adalah bilangan bulat
                        if (Number.isInteger(value)) {
                            return value;
                        }
                    }
                }
            }
        }
    });

    initializeChart('reporterByRolesChart', 'doughnut', {
        responsive: true,
        plugins: {
            legend: { position: 'false', labels: { padding: 15 } }
        }
    });

    initializeChart('perpetratorByRolesChart', 'doughnut', {
        responsive: true,
        plugins: {
            legend: { position: 'false', labels: { padding: 15 } }
        }
    });
});
