// File: resources/js/charts.js

// Variabel global (biarkan seperti yang sudah ada)
let activeChart = null;
const canvasElement = document.getElementById('mainReportChart');
const dataSourceDropdownButton = document.getElementById('dataSourceDropdown');
const chartTypeDropdownButton = document.getElementById('chartTypeDropdown');
const chartCanvasWrapper = canvasElement ? canvasElement.parentElement : null; // Parent dari canvas
const customLegendContainer = document.getElementById('customChartLegend');

let currentDataSource = 'monthly';
let currentChartType = 'line';

function getChartData(dataSourceType) {
    if (!canvasElement) return null;
    switch (dataSourceType) {
        case 'monthly': return JSON.parse(canvasElement.dataset.monthlyData || '[]');
        case 'reporterRoles': return JSON.parse(canvasElement.dataset.reporterRolesData || '{}');
        case 'perpetratorRoles': return JSON.parse(canvasElement.dataset.perpetratorRolesData || '{}');
        default: return null;
    }
}

function generateCustomLegend(labels, dataValues, colors) {
    // ... (Fungsi generateCustomLegend Anda tetap sama persis, tidak perlu diubah)
    if (!customLegendContainer) return;
    customLegendContainer.innerHTML = '';

    const total = dataValues.reduce((sum, value) => sum + value, 0);
    const ul = document.createElement('ul');
    ul.className = 'list-unstyled mb-0';

    labels.forEach((label, index) => {
        const value = dataValues[index];
        const percentage = total > 0 ? (value / total) * 100 : 0;
        const color = colors[index % colors.length];
        const li = document.createElement('li');
        li.className = 'd-flex justify-content-between align-items-center mb-2';
        li.innerHTML = `
            <div>
                <span class="d-inline-block rounded-circle me-2" style="width: 12px; height: 12px; background-color: ${color};"></span>
                <span class="text-capitalize">${label.replace(/_/g, ' ')}</span>
            </div>
            <span class="fw-semibold">${percentage.toFixed(1)}%</span>
        `;
        ul.appendChild(li);
    });
    customLegendContainer.appendChild(ul);
}

function renderActiveChart() {
    if (!canvasElement) return;
    if (activeChart) activeChart.destroy();

    const rawData = getChartData(currentDataSource);
    if (!rawData) {
        console.error('Data source not found or invalid:', currentDataSource);
        return;
    }

    const ctx = canvasElement.getContext('2d');
    let labels, chartDataValues;
    let chartTitle = 'Data Laporan';

    if (currentDataSource === 'monthly') {
        labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        chartDataValues = rawData;
        chartTitle = 'Jumlah Laporan per Bulan';
    } else {
        labels = Object.keys(rawData);
        chartDataValues = Object.values(rawData);
        if (currentDataSource === 'reporterRoles') chartTitle = 'Jumlah Laporan berdasarkan Kategori Pelapor';
        if (currentDataSource === 'perpetratorRoles') chartTitle = 'Jumlah Laporan berdasarkan Kategori Terlapor';
    }

    const categoryColors = [
        '#0d6efd', '#6f42c1', '#198754', '#838383', '#dc3545', '#0dcaf0',
        '#fd7e14', '#20c997', '#6610f2', '#d63384', '#ffc107', '#212529'
    ];

    let datasetOptions = {
        label: chartTitle, // Label ini akan digunakan oleh legenda default Chart.js
        data: chartDataValues,
        tension: 0.2,
    };

    if (currentChartType === 'line') {
        datasetOptions.borderColor = '#525252';
        datasetOptions.backgroundColor = 'rgba(51, 51, 51, 0.1)';
        datasetOptions.fill = true;
    } else if (currentChartType === 'bar') {
        if (currentDataSource === 'reporterRoles' || currentDataSource === 'perpetratorRoles') {
            datasetOptions.backgroundColor = labels.map((_, i) => categoryColors[i % categoryColors.length]);
            datasetOptions.borderColor = labels.map((_, i) => categoryColors[i % categoryColors.length]);
        } else { // Monthly bar chart
            datasetOptions.backgroundColor = 'rgba(13, 110, 253, 0.7)';
            datasetOptions.borderColor = '#0d6efd';
        }
        datasetOptions.borderWidth = 1;
    } else if (currentChartType === 'doughnut') {
        datasetOptions.backgroundColor = labels.map((_, i) => categoryColors[i % categoryColors.length]);
    }

    activeChart = new Chart(ctx, {
        type: currentChartType,
        data: {
            labels: labels,
            datasets: [datasetOptions]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: { display: true, text: chartTitle, font: { size: 16 } },
                legend: {
                    display: (currentChartType === 'doughnut' && currentDataSource === 'monthly'),
                    position: 'top', // Posisi legenda default di atas chart (di bawah judul)
                    labels: {
                        padding: 15 // Beri sedikit padding
                    }
                }
            },
            scales: {
                x: { display: currentChartType !== 'doughnut' },
                y: {
                    display: currentChartType !== 'doughnut',
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        callback: function (value) {
                            if (Math.floor(value) === value) return value;
                        }
                    }
                }
            }
        }
    });

    // ================== PERUBAHAN LOGIKA LEGENDA KUSTOM & LAYOUT ==================
    if (customLegendContainer && chartCanvasWrapper) {
        // Kondisi untuk menampilkan legenda kustom (Doughnut & data kategorikal/peran)
        const showCustomLegend = currentChartType === 'doughnut' &&
            (currentDataSource === 'reporterRoles' || currentDataSource === 'perpetratorRoles');

        if (showCustomLegend) {
            chartCanvasWrapper.style.flexBasis = '55%';
            chartCanvasWrapper.style.maxWidth = '55%';
            chartCanvasWrapper.style.flexGrow = '0';

            customLegendContainer.style.display = 'block';
            customLegendContainer.style.flexBasis = '20%';
            customLegendContainer.style.flexGrow = '1';
            generateCustomLegend(labels, chartDataValues, datasetOptions.backgroundColor);
        } else {
            // Untuk Line, Bar, atau Doughnut bulanan, buat chart mengambil lebar penuh
            // dan sembunyikan legenda kustom
            chartCanvasWrapper.style.flexBasis = '100%';
            chartCanvasWrapper.style.maxWidth = '100%';
            chartCanvasWrapper.style.flexGrow = '1';

            customLegendContainer.innerHTML = '';
            customLegendContainer.style.display = 'none';
            customLegendContainer.style.flexBasis = '0';
        }
    }
    // ================== AKHIR PERUBAHAN LEGENDA KUSTOM & LAYOUT ==================
}

// Event listener (biarkan seperti yang sudah ada)
document.addEventListener('DOMContentLoaded', () => {
    if (!canvasElement) return;
    renderActiveChart();

    const dataSourceLinks = document.querySelectorAll('.data-source-select');
    dataSourceLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            currentDataSource = this.dataset.source;
            if (dataSourceDropdownButton) {
                dataSourceDropdownButton.textContent = this.dataset.sourceText || this.textContent;
            }
            renderActiveChart();
        });
    });

    const chartTypeLinks = document.querySelectorAll('.chart-type-select');
    chartTypeLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            currentChartType = this.dataset.type;
            if (chartTypeDropdownButton) {
                chartTypeDropdownButton.textContent = this.textContent;
            }
            renderActiveChart();
        });
    });
});
