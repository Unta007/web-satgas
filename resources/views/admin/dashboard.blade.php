@extends('layout.admin.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    {{-- Gunakan class container-fluid dari Bootstrap untuk layout full-width dengan padding --}}
    <div class="container-fluid p-4">
        <h1 class="h3 fw-semibold mb-4">Overview</h1>

        <div class="row g-4 mb-5">
            {{-- Kartu Overview --}}
            {{-- Note: Class bg-*-subtle & text-*-emphasis adalah fitur Bootstrap 5.3+. --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 bg-danger-subtle">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">Total Report</h3>
                        <p class="h3 fw-bold text-danger-emphasis">{{ number_format($totalReports) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 bg-primary-subtle">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">Visits</h3>
                        <p class="h3 fw-bold text-primary-emphasis">{{ number_format($visits) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm border-0" style="background-color: #fde6f3;">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">New Users</h3>
                        <p class="h3 fw-bold" style="color: #000000;">{{ number_format($newUsersThisMonth) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 bg-success-subtle">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">Active Users</h3>
                        <p class="h3 fw-bold text-success-emphasis">{{ number_format($activeUsers) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Kolom utama untuk grafik besar --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Report by Month</h5>
                        {{-- Ganti placeholder dengan canvas yang berisi data --}}
                        <div>
                            <canvas id="reportByMonthChart"
                                data-chart-data="{{ json_encode(array_values($reportChartData)) }}" height="250"></canvas>
                            {{-- Menambahkan atribut height untuk rasio --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom samping untuk status dan lainnya --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Overall Report Status</h5>
                        <div class="d-flex flex-column gap-3">
                            @php
                                $statuses = ['review', 'ongoing', 'solved', 'denied', 'archived'];
                                $totalStatusReports = $reportStatusCounts->sum();
                            @endphp

                            @foreach ($statuses as $status)
                                @php
                                    $count = $reportStatusReports[$status] ?? 0;
                                    $percentage = $totalStatusReports > 0 ? ($count / $totalStatusReports) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-capitalize">{{ $status }}</span>
                                        <span>{{ $count }}</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-secondary" role="progressbar"
                                            style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom untuk Pie Chart --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Reporter by Roles</h5>
                        {{-- Wrapper untuk chart dan legenda kustom --}}
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0" style="width: 150px;">
                                <canvas id="reporterByRolesChart"
                                    data-chart-data="{{ json_encode($reporterByRoles) }}"></canvas>
                            </div>
                            <div class="flex-grow-1 ps-4">
                                @php
                                    // Definisikan warna yang sama dengan di JavaScript Anda
                                    $colors = ['#0d6efd', '#198754', '#ffc107', '#838383', '#dc3545'];
                                @endphp
                                <ul class="list-unstyled mb-0">
                                    @foreach ($reporterByRoles as $role => $count)
                                        @php
                                            $percentage = $totalReporters > 0 ? ($count / $totalReporters) * 100 : 0;
                                        @endphp
                                        <li class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <span class="d-inline-block rounded-circle me-2"
                                                    style="width: 9px; height: 9px; background-color: {{ $colors[$loop->index] ?? '#6c757d' }};"></span>
                                                <span class="text-capitalize">{{ $role }}</span>
                                            </div>
                                            <span class="fw-semibold">{{ number_format($percentage, 1) }}%</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Perpetrator by Roles</h5>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0" style="width: 150px;">
                                <canvas id="perpetratorByRolesChart"
                                    data-chart-data="{{ json_encode($perpetratorByRoles) }}"></canvas>
                            </div>
                            <div class="flex-grow-1 ps-4">
                                @php
                                    $colors = ['#0d6efd', '#198754', '#ffc107', '#838383', '#dc3545'];
                                @endphp
                                <ul class="list-unstyled mb-0">
                                    @foreach ($perpetratorByRoles as $role => $count)
                                        @php
                                            $percentage =
                                                $totalPerpetrators > 0 ? ($count / $totalPerpetrators) * 100 : 0;
                                        @endphp
                                        <li class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <span class="d-inline-block rounded-circle me-2"
                                                    style="width: 9px; height: 9px; background-color: {{ $colors[$loop->index] ?? '#6c757d' }};"></span>
                                                <span class="text-capitalize">{{ str_replace('_', ' ', $role) }}</span>
                                            </div>
                                            <span class="fw-semibold">{{ number_format($percentage, 1) }}%</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/dashboard.js')
@endpush
