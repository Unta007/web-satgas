@extends('layout.admin.dashboard')

@section('title', 'View Log Aktivitas')

@section('content')

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 fw-semibold p-2 mb-0">Log Aktivitas Dashboard</h1>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="activityLogTable" class="table table-hover align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                            <th>Nama Staff</th>
                            <th>Keterangan Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activityLogs as $log)
                            <tr>
                                <td data-order="{{ $log->created_at->timestamp }}">
                                    {{ $log->created_at->format('H:i:s') }}</td>
                                <td>{{ $log->created_at->format('Y-m-d') }}</td>
                                <td>{{ $log->causer->name ?? 'Sistem/Tidak Diketahui' }}</td>
                                <td>{!! $log->description !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/activity-log-list.js')
@endpush
