@extends('layout.admin.dashboard')

@section('title', 'Analisis Grafik Laporan')

@section('content')
    <div class="container-fluid p-4">
        <h1 class="h3 fw-semibold mb-4">Grafik Laporan</h1>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="mb-0 me-3">Tampilan Grafik</h5>

                <div class="d-flex flex-wrap mt-2 mt-md-0">
                    <div class="dropdown me-2 mb-2 mb-md-0">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dataSourceDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Laporan per Bulan
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dataSourceDropdown">
                            <li><a class="dropdown-item data-source-select" href="#" data-source="monthly"
                                    data-source-text="Laporan per Bulan">Laporan per Bulan</a></li>
                            <li><a class="dropdown-item data-source-select" href="#" data-source="reporterRoles"
                                    data-source-text="Pelapor berdasarkan Role">Laporan per Kategori Pelapor</a></li>
                            <li><a class="dropdown-item data-source-select" href="#" data-source="perpetratorRoles"
                                    data-source-text="Terlapor berdasarkan Role">Laporan per Kategori Terlapor</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="chartTypeDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Garis (Line)
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartTypeDropdown">
                            <li><a class="dropdown-item chart-type-select" href="#" data-type="line">Garis (Line)</a>
                            </li>
                            <li><a class="dropdown-item chart-type-select" href="#" data-type="bar">Batang (Bar)</a>
                            </li>
                            <li><a class="dropdown-item chart-type-select" href="#" data-type="doughnut">Donut</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Wrapper untuk Canvas dan Legenda Kustom --}}
                <div class="d-flex flex-column flex-md-row align-items-center">
                    {{-- Kolom untuk Canvas Chart --}}
                    <div class="flex-grow-1" style="max-width: 60%; min-height: 400px; position: relative;">
                        {{-- Beri lebar agar legenda bisa muat di kanan --}}
                        <canvas id="mainReportChart" data-monthly-data="{{ json_encode($monthlyReportData) }}"
                            data-reporter-roles-data="{{ json_encode($reporterByRolesData) }}"
                            data-perpetrator-roles-data="{{ json_encode($perpetratorByRolesData) }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                    </div>
                    {{-- Kolom untuk Legenda Kustom (akan diisi oleh JavaScript) --}}
                    <div id="customChartLegend" class="ps-md-0 mt-4 mt-md-0" style="min-width: 80px;">
                        {{-- Legenda akan digenerate oleh JS di sini --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/charts.js')
@endpush
