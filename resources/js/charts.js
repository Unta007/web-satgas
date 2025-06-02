// Variabel untuk menyimpan instance chart yang sedang aktif
// Ini penting agar kita bisa menghancurkannya sebelum membuat yang baru
let activeChart = null;
const canvasElement = document.getElementById('mainReportChart');

/**
 * Fungsi utama untuk merender atau me-render ulang grafik
 * @param {string} chartType Tipe grafik yang diinginkan ('line', 'bar', 'doughnut')
 */
function renderChart(chartType) {
    if (!canvasElement) {
        return;
    }

    // Hancurkan instance chart yang lama jika ada
    if (activeChart) {
        activeChart.destroy();
    }

    const chartData = JSON.parse(canvasElement.dataset.chartData);
    const ctx = canvasElement.getContext('2d');

    // Konfigurasi dasar
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let datasetOptions = {
        label: 'Jumlah Laporan',
        data: chartData,
        tension: 0.2,
    };

    // Kustomisasi warna berdasarkan tipe chart
    if (chartType === 'line') {
        datasetOptions.borderColor = '#0d6efd';
        datasetOptions.backgroundColor = 'rgba(13, 110, 253, 0.1)';
        datasetOptions.fill = true;
    } else if (chartType === 'bar') {
        datasetOptions.backgroundColor = 'rgba(13, 110, 253, 0.7)';
        datasetOptions.borderColor = '#0d6efd';
        datasetOptions.borderWidth = 1;
    } else if (chartType === 'doughnut') {
        datasetOptions.backgroundColor = [
            '#0d6efd', '#6f42c1', '#198754', '#ffc107', '#dc3545', '#0dcaf0',
            '#fd7e14', '#20c997', '#6610f2', '#d63384', '#adb5bd', '#212529'
        ];
    }

    // Buat instance chart baru dan simpan ke variabel global
    activeChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: labels,
            datasets: [datasetOptions]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    // Hanya tampilkan legenda untuk donut chart
                    display: chartType === 'doughnut'
                }
            }
        }
    });
}

// Event listener untuk dijalankan setelah halaman siap
document.addEventListener('DOMContentLoaded', () => {
    // Render grafik default (line chart) saat halaman pertama kali dimuat
    renderChart('line');

    const dropdownButton = document.getElementById('chartTypeDropdown');
    const chartTypeLinks = document.querySelectorAll('.chart-type-select');

    // Tambahkan event listener untuk setiap pilihan di dropdown
    chartTypeLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Mencegah link berpindah halaman

            const selectedType = this.dataset.type;
            const selectedText = this.textContent;

            // Render ulang grafik dengan tipe yang baru
            renderChart(selectedType);

            // Update teks pada tombol dropdown
            if (dropdownButton) {
                dropdownButton.textContent = selectedText;
            }
        });
    });
});
