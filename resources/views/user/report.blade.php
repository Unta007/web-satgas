@extends('layout.app')

@section('title', 'Buat Laporan')

@section('content')

    @php
        $breadcrumbs = [['name' => 'Beranda', 'url' => route('home')], ['name' => 'Buat Laporan']];
    @endphp
    <x-hero title="Formulir Laporan Insiden"
        subtitle="Laporkan setiap insiden dengan aman dan terstruktur. Setiap informasi yang Anda berikan sangat berharga dan akan dijaga kerahasiaannya."
        :breadcrumbs="$breadcrumbs" />

    <div class="report-page-wrapper">
        <aside class="report-guidance">
            <div class="guidance-content">
                <h3>Panduan Pelaporan</h3>
                <p>Formulir ini dirancang untuk membantu Anda melaporkan kejadian dengan aman dan terstruktur. Setiap
                    informasi yang Anda berikan sangat berharga.</p>

                <div class="guidance-section">
                    <i class="bi bi-shield-lock"></i>
                    <div>
                        <h5>Kerahasiaan Terjamin</h5>
                        <p>Identitas dan laporan Anda akan dijaga kerahasiaannya sesuai dengan standar perlindungan data dan
                            privasi.</p>
                    </div>
                </div>

                <div class="guidance-section">
                    <i class="bi bi-card-text"></i>
                    <div>
                        <h5>Jelaskan Secara Rinci</h5>
                        <p>Cobalah untuk memberikan detail yang jelas dan kronologis untuk membantu kami memahami situasi
                            dengan lebih baik.</p>
                    </div>
                </div>

                <div class="guidance-section">
                    <i class="bi bi-paperclip"></i>
                    <div>
                        <h5>Sertakan Bukti</h5>
                        <p>Bukti pendukung seperti foto, tangkapan layar, atau dokumen dapat sangat memperkuat laporan Anda.
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- KOLOM KANAN: FORMULIR PELAPORAN --}}
        <main class="report-form-container">
            <header class="form-header">
                <h1>Formulir Laporan Insiden</h1>
                <p>Silakan isi kolom di bawah ini dengan informasi yang akurat.</p>
            </header>

            @if (session('success') && session('redirect_url'))
                <div id="flash-message" data-message="{{ session('success') }}" data-type="success"
                    data-redirect-url="{{ session('redirect_url') }}" style="display: none;">
                </div>
            @elseif (session('success'))
                <div id="flash-message" data-message="{{ session('success') }}" data-type="success" style="display: none;">
                </div>
            @elseif (session('error'))
                <div id="flash-message" data-message="{{ session('error') }}" data-type="error" style="display: none;">
                </div>
            @endif

            @auth
                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="report-form"
                    id="report-form">
                    @csrf

                    {{-- SEKSI 1: DETAIL KEJADIAN --}}
                    <fieldset class="form-section">
                        <legend>1. Detail Kejadian</legend>
                        <div class="form-group">
                            <label for="what_happened">Apa yang terjadi? Jelaskan dengan rinci <span
                                    class="required"></span></label>
                            <textarea class="form-control @error('what_happened') is-invalid @enderror" id="what_happened" name="what_happened"
                                rows="5" placeholder="Contoh: Pada tanggal... di lokasi..., saya melihat/mengalami...">{{ old('what_happened') }}</textarea>
                            @error('what_happened')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="where_happened">Di mana hal ini terjadi? <span class="required"></span></label>
                            <input type="text" class="form-control @error('where_happened') is-invalid @enderror"
                                id="where_happened" name="where_happened" placeholder="Contoh: Gedung A, Ruang 101"
                                value="{{ old('where_happened') }}">
                            @error('where_happened')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="when_happened">Kapan hal ini terjadi? <span class="required"></span></label>
                                <input type="datetime-local" class="form-control @error('when_happened') is-invalid @enderror"
                                    id="when_happened" name="when_happened" value="{{ old('when_happened') }}">
                                @error('when_happened')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="reporter_role">Peran Anda sebagai pelapor <span class="required"></span></label>
                                <select class="form-select @error('reporter_role') is-invalid @enderror" id="reporter_role"
                                    name="reporter_role">
                                    <option value="" disabled selected>Pilih peran Anda</option>
                                    <option value="mahasiswa" {{ old('reporter_role') == 'mahasiswa' ? 'selected' : '' }}>
                                        Mahasiswa</option>
                                    <option value="staff" {{ old('reporter_role') == 'staff' ? 'selected' : '' }}>Staff
                                    </option>
                                    <option value="dosen" {{ old('reporter_role') == 'dosen' ? 'selected' : '' }}>Dosen
                                    </option>
                                    <option value="lainnya" {{ old('reporter_role') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('reporter_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- SEKSI 2: INFORMASI SAKSI --}}
                    <fieldset class="form-section">
                        <legend>2. Informasi Saksi</legend>
                        <div class="form-group">
                            <label>Apakah ada saksi dalam kejadian ini? <span class="required"></span></label>

                            {{-- DIUBAH: Menggunakan struktur form-check --}}
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('has_witness') is-invalid @enderror" type="radio"
                                        name="has_witness" id="witness_yes" value="yes"
                                        {{ old('has_witness') == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="witness_yes">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('has_witness') is-invalid @enderror" type="radio"
                                        name="has_witness" id="witness_no" value="no"
                                        {{ old('has_witness', 'no') == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="witness_no">Tidak</label>
                                </div>
                            </div>
                            @error('has_witness')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="witness_fields" class="conditional-fields"
                            style="{{ old('has_witness') == 'yes' ? '' : 'display: none;' }}">
                            <div class="form-group">
                                <label for="witness_name">Nama saksi</label>
                                <input type="text" class="form-control @error('witness_name') is-invalid @enderror"
                                    id="witness_name" name="witness_name" placeholder="Isi nama saksi"
                                    value="{{ old('witness_name') }}">
                                @error('witness_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="witness_relation">Hubungan Anda dengan saksi</label>
                                <select class="form-select @error('witness_relation') is-invalid @enderror"
                                    id="witness_relation" name="witness_relation">
                                    <option value="" disabled selected>Pilih hubungan</option>
                                    <option value="teman" {{ old('witness_relation') == 'teman' ? 'selected' : '' }}>Teman
                                    </option>
                                    <option value="rekan_kerja"
                                        {{ old('witness_relation') == 'rekan_kerja' ? 'selected' : '' }}>Rekan Kerja/Studi
                                    </option>
                                    <option value="keluarga" {{ old('witness_relation') == 'keluarga' ? 'selected' : '' }}>
                                        Keluarga</option>
                                    <option value="tidak_kenal"
                                        {{ old('witness_relation') == 'tidak_kenal' ? 'selected' : '' }}>Tidak Kenal</option>
                                    <option value="lainnya" {{ old('witness_relation') == 'lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('witness_relation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- SEKSI 3: INFORMASI TERLAPOR --}}
                    <fieldset class="form-section">
                        <legend>3. Informasi Terlapor</legend>
                        <div class="form-group">
                            <label>Apakah Anda mengetahui identitas terlapor? <span class="required"></span></label>

                            {{-- DIUBAH: Menggunakan struktur form-check --}}
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('knows_perpetrator') is-invalid @enderror"
                                        type="radio" name="knows_perpetrator" id="perpetrator_yes" value="yes"
                                        {{ old('knows_perpetrator') == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perpetrator_yes">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('knows_perpetrator') is-invalid @enderror"
                                        type="radio" name="knows_perpetrator" id="perpetrator_no" value="no"
                                        {{ old('knows_perpetrator', 'no') == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perpetrator_no">Tidak</label>
                                </div>
                            </div>
                            @error('knows_perpetrator')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="perpetrator_fields" class="conditional-fields"
                            style="{{ old('knows_perpetrator') == 'yes' ? '' : 'display: none;' }}">
                            <div class="form-group">
                                <label for="perpetrator_name">Nama terlapor</label>
                                <input type="text" class="form-control @error('perpetrator_name') is-invalid @enderror"
                                    id="perpetrator_name" name="perpetrator_name" placeholder="Isi nama terlapor"
                                    value="{{ old('perpetrator_name') }}">
                                @error('perpetrator_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="perpetrator_role">Status terlapor</label>
                                <select class="form-select @error('perpetrator_role') is-invalid @enderror"
                                    id="perpetrator_role" name="perpetrator_role">
                                    <option value="" disabled selected>Pilih status terlapor</option>
                                    <option value="mahasiswa" {{ old('perpetrator_role') == 'mahasiswa' ? 'selected' : '' }}>
                                        Mahasiswa</option>
                                    <option value="staff" {{ old('perpetrator_role') == 'staff' ? 'selected' : '' }}>Staff
                                    </option>
                                    <option value="dosen" {{ old('perpetrator_role') == 'dosen' ? 'selected' : '' }}>Dosen
                                    </option>
                                    <option value="lainnya" {{ old('perpetrator_role') == 'lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('perpetrator_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- SEKSI 4: BUKTI & PERSETUJUAN --}}
                    <fieldset class="form-section">
                        <legend>4. Bukti & Persetujuan</legend>
                        <div class="form-group">
                            <label for="evidence">Unggah bukti pendukung</label>
                            <div class="file-upload-wrapper">
                                <input type="file" id="evidence" name="evidence"
                                    class="file-upload-input @error('evidence') is-invalid @enderror"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <div class="file-upload-ui">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <p><strong>Pilih file untuk diunggah</strong> atau seret ke sini</p>
                                    <small>PDF, DOC, JPG, PNG (Max. 9MB)</small>
                                    <span class="file-name"></span>
                                </div>
                            </div>
                            @error('evidence')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group agreement-box">
                            <h5>Pernyataan & Persetujuan</h5>
                            <p class="small">Dengan melanjutkan, saya menyatakan bahwa informasi yang saya sampaikan adalah
                                benar dan saya menyetujui data saya diproses sesuai kebijakan yang berlaku untuk investigasi
                                laporan ini.</p>

                            {{-- DIUBAH: Menggunakan struktur form-check untuk checkbox --}}
                            <div class="form-check">
                                <input class="form-check-input @error('agreement') is-invalid @enderror" type="checkbox"
                                    name="agreement" value="1" id="agreement" {{ old('agreement') ? 'checked' : '' }}>
                                <label class="form-check-label" for="agreement">
                                    Saya menyetujui pernyataan di atas. <span class="required"></span>
                                </label>
                            </div>
                            @error('agreement')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning-custom">
                    Harap <a href="{{ route('login') }}">login</a> atau <a href="{{ route('register') }}">daftar</a> untuk
                    membuat laporan.
                </div>
            @endauth
        </main>
    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/report.js')
@endpush
