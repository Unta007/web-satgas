@extends('layout.admin.dashboard')

@section('title', 'Archived Reports List')

@section('content')
    <div class="container-fluid p-4">
        {{-- Breadcrumb bisa diaktifkan jika diperlukan
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Reports List</li>
                <li class="breadcrumb-item active" aria-current="page">Archived</li>
            </ol>
        </nav>
        --}}

        <h1 class="h3 fw-semibold mb-4">Archived Reports List</h1>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ReportsTable" class="table table-hover align-middle" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Report ID</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Last Status</th>
                                <th scope="col">Date Archived</th> {{-- Menggunakan updated_at sebagai tanggal arsip --}}
                                <th scope="col">Time Archived</th> {{-- Menggunakan updated_at sebagai waktu arsip --}}
                                <th scope="col" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reports as $report)
                                <tr>
                                    <td>{{ $report->user->username ?? 'N/A' }}</td>
                                    <td data-order="{{ $report->id }}">#{{ $report->id }}</td>
                                    <td>{{ $report->user->phone_number ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            // Logika badge status Anda
                                            $statusClass =
                                                'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle';
                                            $statusIcon = 'bi-info-circle';
                                            switch (strtolower($report->status)) {
                                                case 'unread':
                                                    $statusClass =
                                                        'text-danger-emphasis bg-danger-subtle border-danger-subtle';
                                                    $statusIcon = 'bi-eye-slash';
                                                    break;
                                                case 'review':
                                                    $statusClass =
                                                        'text-info-emphasis bg-info-subtle border-info-subtle';
                                                    $statusIcon = 'bi-search';
                                                    break;
                                                case 'ongoing':
                                                    $statusClass =
                                                        'text-warning-emphasis bg-warning-subtle border-warning-subtle';
                                                    $statusIcon = 'bi-hourglass-split';
                                                    break;
                                                case 'solved':
                                                    $statusClass =
                                                        'text-success-emphasis bg-success-subtle border-success-subtle';
                                                    $statusIcon = 'bi-check-circle-fill';
                                                    break;
                                                case 'denied':
                                                    $statusClass =
                                                        'text-danger-emphasis bg-danger-subtle border-danger-subtle';
                                                    $statusIcon = 'bi-x-circle-fill';
                                                    break;
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill py-1 px-2">
                                            <i class="bi {{ $statusIcon }} me-1"></i>
                                            {{ strtoupper($report->status) }}
                                        </span>
                                        @if ($report->is_archived ?? false)
                                            {{-- Tambahkan pengecekan is_archived jika ada di semua konteks --}}
                                            <span
                                                class="badge bg-dark-subtle text-dark-emphasis border border-dark-subtle rounded-pill py-1 px-2 ms-1">
                                                <i class="bi bi-archive-fill me-1"></i>
                                                ARCHIVED
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $report->updated_at->format('Y-m-d') }}</td>
                                    <td>{{ $report->updated_at->format('H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('admin.reports.edit', $report->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="View/Edit (Unarchive)">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST"
                                            class="d-inline delete-report-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete Permanently">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    {{-- Pastikan report-list.js dapat menginisialisasi DataTables untuk #archivedReportsTable --}}
    @vite('resources/js/report-list.js')
@endpush
