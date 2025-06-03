@extends('layout.admin.dashboard')

@section('title', 'Edit Status Laporan #' . $report->id)

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 fw-semibold mb-0">Report #{{ $report->id }}</h1>
            <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST" class="ms-auto"
                id="updateStatusForm">
                @csrf
                @method('PUT')
                <div class="input-group">
                    <label class="input-group-text" for="statusSelect">Status</label>
                    <select class="form-select" id="statusSelect" name="status"
                        data-original-status="{{ $report->status }}">
                        @foreach ($availableStatuses as $statusValue)
                            <option value="{{ $statusValue }}" {{ $report->status == $statusValue ? 'selected' : '' }}>
                                {{ ucfirst($statusValue) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row">
                    {{-- Informasi Pelapor --}}
                    <div class="mt-0 mb-2">
                        <h4 class="fw-medium">Informasi Pelapor</h4>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Nama Pelapor</label>
                        <input type="text" class="form-control" value="{{ $report->user->username ?? 'N/A' }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Nomor Aktif Pelapor</label>
                        <input type="text" class="form-control" value="{{ $report->user->phone_number ?? 'N/A' }}"
                            disabled>
                    </div>

                    {{-- Detail Kejadian --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-medium">Apa yang terjadi? Jelaskan dengan rinci</label>
                        <textarea class="form-control" rows="4" disabled>{{ $report->what_happened }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Di mana hal ini terjadi?</label>
                        <input type="text" class="form-control" value="{{ $report->where_happened }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Kapan hal ini terjadi?</label>
                        <input type="text" class="form-control"
                            value="{{ $report->when_happened ? \Carbon\Carbon::parse($report->when_happened)->format('d / m / Y - H:i') : 'N/A' }}"
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Status pelapor saat ini</label>
                        <input type="text" class="form-control text-capitalize" value="{{ $report->reporter_role }}"
                            disabled>
                    </div>

                    {{-- Informasi Saksi --}}
                    <div class="col-12 mt-3 mb-2">
                        <h4 class="fw-medium">Informasi Saksi</h4>
                    </div>
                    <div class="md-6 mb-3">
                        <label class="form-label">Apakah ada saksi dalam kejadian ini?</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_witness_display"
                                    id="has_witness_yes_display" value="yes"
                                    {{ $report->has_witness == 'yes' ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="has_witness_yes_display">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_witness_display"
                                    id="has_witness_no_display" value="no"
                                    {{ $report->has_witness == 'no' ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="has_witness_no_display">Tidak</label>
                            </div>
                        </div>
                    </div>
                    @if ($report->has_witness == 'yes')
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nama Saksi</label>
                            <input type="text" class="form-control" value="{{ $report->witness_name ?? 'N/A' }}"
                                disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Status atau hubungan pelapor dengan saksi</label>
                            <input type="text" class="form-control text-capitalize"
                                value="{{ $report->witness_relation ?? 'N/A' }}" disabled>
                        </div>
                    @endif

                    {{-- Informasi Terlapor --}}
                    <div class="mt-3 mb-2">
                        <h4 class="fw-medium">Informasi Terlapor</h4>
                    </div>
                    <div class="md-6 mb-3">
                        <label class="form-label">Apakah pelapor mengetahui identitas terlapor?</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="knows_perpetrator_display"
                                    id="knows_perpetrator_yes_display" value="yes"
                                    {{ $report->knows_perpetrator == 'yes' ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="knows_perpetrator_yes_display">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="knows_perpetrator_display"
                                    id="knows_perpetrator_no_display" value="no"
                                    {{ $report->knows_perpetrator == 'no' ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="knows_perpetrator_no_display">Tidak</label>
                            </div>
                        </div>
                    </div>
                    @if ($report->knows_perpetrator == 'yes')
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nama Terlapor</label>
                            <input type="text" class="form-control" value="{{ $report->perpetrator_name ?? 'N/A' }}"
                                disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Status atau hubungan pelapor dengan terlapor</label>
                            <input type="text" class="form-control text-capitalize"
                                value="{{ str_replace('_', ' ', $report->perpetrator_role ?? 'N/A') }}" disabled>
                        </div>
                    @else
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Status atau hubungan pelapor dengan terlapor</label>
                            <input type="text" class="form-control text-capitalize"
                                value="{{ str_replace('_', ' ', $report->perpetrator_role ?? 'Tidak Diketahui') }}"
                                disabled>
                        </div>
                    @endif

                    {{-- Bukti Pendukung --}}
                    @if ($report->evidence_path)
                        <div class="col-12 mt-1 mb-3">
                            <div class="mt-3">
                                <h4 class="fw-medium">Bukti Pendukung</h4> {{-- Ditambahkan fw-medium agar konsisten --}}
                            </div>
                            <div>
                                {{-- Ubah link ini untuk mengarah ke route download --}}
                                <a href="{{ route('admin.reports.downloadEvidence', $report->id) }}"
                                    class="btn btn-outline-primary btn-sm"> {{-- Mengganti btn-outline-info menjadi primary --}}
                                    <i class="bi bi-download me-1"></i> Unduh Bukti
                                </a>
                                <small class="d-block text-muted mt-1">Nama file:
                                    {{ basename($report->evidence_path) }}</small>
                            </div>
                        </div>
                    @endif
                    <div class="col-12 mt-3 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agreement_display"
                                {{ $report->agreement ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="agreement_display">
                                Pelapor telah menyetujui Pernyataan dan Persetujuan.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <a href="{{ route($backRouteName) }}" class="btn btn-secondary">Kembali ke Daftar Laporan</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/report-edit.js')
@endpush
