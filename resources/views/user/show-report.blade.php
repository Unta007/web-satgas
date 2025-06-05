@extends('layout.app') {{-- Menggunakan layout yang sama dengan halaman pelaporan --}}

@section('title', 'Detail Laporan #' . $report->id)

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Detail Laporan #{{ $report->id }}</h1>
                <div>
                    @php
                        $statusClass = 'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle'; // Default
                        $statusText = strtoupper($report->status);
                        switch (strtolower($report->status)) {
                            case 'unread':
                                $statusClass = 'text-danger-emphasis bg-danger-subtle border-danger-subtle';
                                break;
                            case 'review':
                                $statusClass = 'text-info-emphasis bg-info-subtle border-info-subtle';
                                break;
                            case 'ongoing':
                                $statusClass = 'text-warning-emphasis bg-warning-subtle border-warning-subtle';
                                break;
                            case 'solved':
                                $statusClass = 'text-success-emphasis bg-success-subtle border-success-subtle';
                                break;
                            case 'denied':
                                $statusClass = 'text-danger-emphasis bg-danger-subtle border-danger-subtle'; // Bisa dibedakan dengan unread jika perlu
                                break;
                            case 'archived': // Jika Anda ingin menampilkan status 'archived' secara khusus
                                $statusClass = 'text-dark-emphasis bg-dark-subtle border-dark-subtle';
                                $statusText = 'ARCHIVED (ASLI: ' . strtoupper($report->status) . ')'; // Menampilkan status asli jika diarsipkan
                                if ($report->is_archived) {
                                    // Jika ada kolom is_archived
                                    $statusText = 'ARCHIVED (ASLI: ' . strtoupper($report->status) . ')';
                                }
                                break;
                        }
                        if ($report->is_archived ?? false) {
                            // Jika ada kolom is_archived dan true
                            $statusClass = 'text-dark-emphasis bg-dark-subtle border-dark-subtle';
                            $statusText = 'DIARSIPKAN (Status Asli: ' . strtoupper($report->status) . ')';
                        }
                    @endphp
                    <span class="badge rounded-pill px-3 py-2 fs-6 {{ $statusClass }}">
                        Status: {{ $statusText }}
                    </span>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Detail Laporan --}}
            <div class="mb-4">
                <h5 class="fw-semibold border-bottom pb-2 mb-3">Detail Kejadian</h5>
                <div class="mb-3">
                    <label class="form-label fw-medium">Apa yang terjadi?</label>
                    <p class="form-control-plaintext bg-light p-2 rounded">{{ $report->what_happened }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Di mana hal ini terjadi?</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">{{ $report->where_happened }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Kapan hal ini terjadi?</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            {{ $report->when_happened ? \Carbon\Carbon::parse($report->when_happened)->format('d F Y - H:i') : 'N/A' }}
                        </p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Status Anda saat kejadian (sebagai pelapor)</label>
                    <p class="form-control-plaintext bg-light p-2 rounded text-capitalize">{{ $report->reporter_role }}</p>
                </div>
            </div>

            {{-- Informasi Saksi --}}
            <div class="mb-4">
                <h5 class="fw-semibold border-bottom pb-2 mb-3">Informasi Saksi</h5>
                <div class="mb-3">
                    <label class="form-label fw-medium">Apakah ada saksi?</label>
                    <p class="form-control-plaintext bg-light p-2 rounded text-capitalize">
                        {{ $report->has_witness == 'yes' ? 'Ya' : 'Tidak' }}</p>
                </div>
                @if ($report->has_witness == 'yes')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nama Saksi</label>
                            <p class="form-control-plaintext bg-light p-2 rounded">{{ $report->witness_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Status atau hubungan Anda dengan saksi</label>
                            <p class="form-control-plaintext bg-light p-2 rounded text-capitalize">
                                {{ $report->witness_relation ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Informasi Terlapor --}}
            <div class="mb-4">
                <h5 class="fw-semibold border-bottom pb-2 mb-3">Informasi Terlapor</h5>
                <div class="mb-3">
                    <label class="form-label fw-medium">Apakah Anda mengetahui identitas terlapor?</label>
                    <p class="form-control-plaintext bg-light p-2 rounded text-capitalize">
                        {{ $report->knows_perpetrator == 'yes' ? 'Ya' : 'Tidak' }}</p>
                </div>
                @if ($report->knows_perpetrator == 'yes')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nama Terlapor</label>
                            <p class="form-control-plaintext bg-light p-2 rounded">{{ $report->perpetrator_name ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Status terlapor</label>
                            <p class="form-control-plaintext bg-light p-2 rounded text-capitalize">
                                {{ str_replace('_', ' ', $report->perpetrator_role ?? 'N/A') }}</p>
                        </div>
                    </div>
                @else
                    @if ($report->perpetrator_role && $report->perpetrator_role !== 'tidak_diketahui')
                        <div class="mb-3">
                            <label class="form-label fw-medium">Status terlapor</label>
                            <p class="form-control-plaintext bg-light p-2 rounded text-capitalize">
                                {{ str_replace('_', ' ', $report->perpetrator_role) }}</p>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Bukti Pendukung --}}
            @if ($report->evidence_path)
                <div class="mb-4">
                    <h5 class="fw-semibold border-bottom pb-2 mb-3">Bukti Pendukung</h5>
                    <a href="{{ route('reports.downloadEvidence', $report->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-download me-1"></i> Unduh Bukti ({{ basename($report->evidence_path) }})
                    </a>
                    @php
                        $extension = pathinfo($report->evidence_path, PATHINFO_EXTENSION);
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    @endphp
                </div>
            @endif

            {{-- Pernyataan Persetujuan --}}
            <div class="mb-4">
                <h5 class="fw-semibold border-bottom pb-2 mb-3">Persetujuan</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" {{ $report->agreement ? 'checked' : '' }} disabled>
                    <label class="form-check-label">
                        Pelapor telah menyetujui Pernyataan dan Persetujuan saat membuat laporan.
                    </label>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
                {{-- Jika Anda memiliki halaman daftar laporan pengguna:
            <a href="{{ route('user.reports.index') }}" class="btn btn-secondary">Kembali ke Daftar Laporan Saya</a>
            --}}
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    {{-- Jika ada script khusus untuk halaman ini --}}
@endpush
