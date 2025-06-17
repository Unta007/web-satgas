@extends('layout.admin.dashboard')

@section('title', 'Unread Reports List')

@section('content')

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-semibold p-2 mb-0">Daftar Laporan Belum Dibaca</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="ReportsTable" class="table table-hover align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Report ID</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Report Status</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Tanggal</th>
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
                                    @if ($report->status == 'unread')
                                        <span
                                            class="badge text-info-emphasis bg-info-subtle border border-info-subtle rounded-pill py-1 px-2 ms-1">
                                            <i class="bi bi-eye-slash me-1"></i> UNREAD
                                        </span>
                                    @else
                                        <span
                                            class="badge text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-pill">
                                            {{ strtoupper($report->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $report->created_at->format('H:i:s') }}</td>
                                <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.edit', $report->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="View/Edit Status">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST"
                                        class="d-inline delete-report-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash3"></i>
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
    @vite('resources/js/report-list.js')
@endpush
