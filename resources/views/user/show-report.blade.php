@extends('layout.app')

@section('title', 'Detail Laporan #' . $report->id)

@section('content')
    <div class="report-page-wrapper">
        <aside class="report-guidance">
            <div class="guidance-content">
                <h3>Ringkasan Laporan</h3>

                <div class="summary-item mb-3">
                    <span class="detail-label">ID Laporan</span>
                    <span class="detail-data">#{{ $report->id }}</span>
                </div>

                <div class="summary-item mb-3">
                    <span class="detail-label">Tanggal Dilaporkan</span>
                    <span class="detail-data">{{ $report->created_at->format('d F Y, H:i') }}</span>
                </div>

                <div class="summary-item mb-3">
                    <span class="detail-label">Status Laporan Saat Ini</span>
                    @php
                        // Logika status yang sama untuk konsistensi
                        $statusClass = 'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle';
                        $statusText = strtoupper($report->status);
                        switch (strtolower($report->status)) {
                            case 'unread':
                                $statusClass = 'text-info-emphasis bg-info-subtle border-info-subtle';
                                break;
                            case 'review':
                                $statusClass = 'text-primary-emphasis bg-primary-subtle border-primary-subtle';
                                break;
                            case 'ongoing':
                                $statusClass = 'text-warning-emphasis bg-warning-subtle border-warning-subtle';
                                break;
                            case 'solved':
                                $statusClass = 'text-success-emphasis bg-success-subtle border-success-subtle';
                                break;
                            case 'denied':
                                $statusClass = 'text-danger-emphasis bg-danger-subtle border-danger-subtle';
                                break;
                        }
                    @endphp
                    <span class="badge rounded-pill fs-6 {{ $statusClass }} py-2">
                        {{ $statusText }}
                    </span>
                </div>

                <div class="summary-item mb-1">
                    @if ($report->status == 'denied' && !empty($report->rejection_note))
                        <div class="alert alert-danger mb-4">
                            <p class="mb-4">Laporan ini telah ditolak dengan alasan berikut:</p>
                            <p class="mb-0 fst-italic">"{!! nl2br(e($report->rejection_note)) !!}"</p>
                        </div>
                    @endif
                </div>

                <div class="summary-item">
                    <span class="detail-label">Keterangan Status</span>
                    <div class="row">
                        <div class="col mb-1">
                            <span class="badge text-info-emphasis bg-info-subtle border border-info-subtle rounded-pill">
                                UNREAD
                            </span>
                            <span class="status-description">: Belum dibaca</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <span class="badge text-primary-emphasis bg-primary-subtle border-primary-subtle rounded-pill">
                                REVIEW
                            </span>
                            <span class="status-description">: Sedang Ditinjau</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <span class="badge text-warning-emphasis bg-warning-subtle border-warning-subtle rounded-pill">
                                ONGOING
                            </span>
                            <span class="status-description">: Sedang Berlangsung</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <span class="badge text-success-emphasis bg-success-subtle border-success-subtle rounded-pill">
                                SOLVED
                            </span>
                            <span class="status-description">: Laporan Selesai</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <span class="badge text-danger-emphasis bg-danger-subtle border-danger-subtle rounded-pill">
                                DENIED
                            </span>
                            <span class="status-description">: Laporan Ditolak</span>
                        </div>
                    </div>
                </div>
        </aside>

        {{-- KOLOM KANAN: DETAIL LENGKAP LAPORAN --}}
        <main class="report-form-container">
            <header class="form-header">
                <h1>Detail Laporan</h1>
                <p>Disajikan di bawah ini adalah rincian lengkap dari laporan yang telah Anda buat.</p>
            </header>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- SEKSI 1: DETAIL KEJADIAN --}}
            <fieldset class="form-section">
                <legend>1. Detail Kejadian</legend>
                <div class="detail-group">
                    <label class="detail-label">Apa yang terjadi?</label>
                    <p class="detail-data">{{ $report->what_happened }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Di mana hal ini terjadi?</label>
                            <p class="detail-data">{{ $report->where_happened }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <label class="detail-label">Kapan hal ini terjadi?</label>
                            <p class="detail-data">
                                {{ $report->when_happened ? \Carbon\Carbon::parse($report->when_happened)->format('d F Y - H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="detail-group">
                    <label class="detail-label">Status Anda saat kejadian (sebagai pelapor)</label>
                    <p class="detail-data text-capitalize">{{ $report->reporter_role }}</p>
                </div>
            </fieldset>

            {{-- SEKSI 2: INFORMASI SAKSI --}}
            <fieldset class="form-section">
                <legend>2. Informasi Saksi</legend>
                <div class="detail-group">
                    <label class="detail-label">Apakah ada saksi?</label>
                    <p class="detail-data text-capitalize">{{ $report->has_witness == 'yes' ? 'Ya' : 'Tidak' }}</p>
                </div>
                @if ($report->has_witness == 'yes')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label class="detail-label">Nama Saksi</label>
                                <p class="detail-data">{{ $report->witness_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label class="detail-label">Hubungan dengan saksi</label>
                                <p class="detail-data text-capitalize">{{ $report->witness_relation ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </fieldset>

            {{-- SEKSI 3: INFORMASI TERLAPOR --}}
            <fieldset class="form-section">
                <legend>3. Informasi Terlapor</legend>
                <div class="detail-group">
                    <label class="detail-label">Apakah identitas terlapor diketahui?</label>
                    <p class="detail-data text-capitalize">{{ $report->knows_perpetrator == 'yes' ? 'Ya' : 'Tidak' }}</p>
                </div>
                @if ($report->knows_perpetrator == 'yes')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label class="detail-label">Nama Terlapor</label>
                                <p class="detail-data">{{ $report->perpetrator_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label class="detail-label">Status terlapor</label>
                                <p class="detail-data text-capitalize">
                                    {{ str_replace('_', ' ', $report->perpetrator_role ?? 'N/A') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </fieldset>

            {{-- SEKSI 4: BUKTI & PERSETUJUAN --}}
            <fieldset class="form-section">
                <legend>4. Bukti & Persetujuan</legend>
                @if ($report->evidence_path)
                    <div class="detail-group">
                        <label class="detail-label">Bukti Pendukung</label>
                        <a href="{{ route('reports.downloadEvidence', $report->id) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download me-1"></i> Unduh Bukti ({{ basename($report->evidence_path) }})
                        </a>
                    </div>
                @endif
                <div class="detail-group">
                    <label class="detail-label">Persetujuan</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" {{ $report->agreement ? 'checked' : '' }} disabled>
                        <label class="form-check-label">
                            Pelapor telah menyetujui Pernyataan dan Persetujuan saat membuat laporan.
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Kembali ke Profil</a>
            </div>
        </main>
    </div>
@endsection
