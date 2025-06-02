@extends('layout.admin.dashboard')

@section('title', 'Analisis Grafik Laporan')

@section('content')
    <div class="container-fluid p-4">
        <h1 class="h2 fw-semibold mb-4">Grafik Laporan per Bulan</h1>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tampilan Grafik</h5>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="chartTypeDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Garis (Line)
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartTypeDropdown">
                        <li><a class="dropdown-item chart-type-select" href="#" data-type="line">Garis (Line)</a></li>
                        <li><a class="dropdown-item chart-type-select" href="#" data-type="bar">Batang (Bar)</a></li>
                        <li><a class="dropdown-item chart-type-select" href="#" data-type="doughnut">Donut</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                {{-- Elemen canvas ini akan kita gunakan untuk semua tipe grafik --}}
                {{-- Data laporan kita sematkan di sini --}}
                <canvas id="mainReportChart" data-chart-data="{{ json_encode($reportChartData) }}"
                    style="min-height: 400px;"></canvas>
            </div>
        </div>
    </div>
@endsection

{{-- Kita akan memuat file JS khusus untuk halaman ini --}}
@push('page-scripts')
    @vite('resources/js/charts.js')
@endpush
