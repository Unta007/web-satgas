@extends('layout.app')

@section('title', 'Pelaporan')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card p-4 shadow-sm">
        <h1 class="mb-4 text-center">Pelaporan</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        @auth
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ... field what_happened, where_happened, when_happened, reporter_role ... --}}
                {{-- Saya salin dari kode Anda sebelumnya, diasumsikan sudah benar --}}
                <div class="mb-3">
                    <label for="what_happened" class="form-label">Apa yang terjadi? Jelaskan dengan rinci <span
                            class="text-danger">*</span></label>
                    <textarea class="form-control @error('what_happened') is-invalid @enderror" id="what_happened" name="what_happened" rows="3"
                        placeholder="Isi kronologi kejadian">{{ old('what_happened') }}</textarea>
                    @error('what_happened')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="where_happened" class="form-label">Di mana hal ini terjadi? <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('where_happened') is-invalid @enderror" id="where_happened" name="where_happened"
                        placeholder="Isi tempat kejadian" value="{{ old('where_happened') }}">
                    @error('where_happened')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="when_happened" class="form-label">Kapan hal ini terjadi? <span
                                class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('when_happened') is-invalid @enderror" id="when_happened" name="when_happened"
                            value="{{ old('when_happened') }}">
                        @error('when_happened')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reporter_role" class="form-label">Status Anda saat ini (sebagai pelapor) <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('reporter_role') is-invalid @enderror" id="reporter_role" name="reporter_role">
                            <option value="" disabled {{ !old('reporter_role') ? 'selected' : '' }}>Pilih status Anda</option>
                            <option value="mahasiswa" {{ old('reporter_role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="staff" {{ old('reporter_role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="dosen" {{ old('reporter_role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="lainnya" {{ old('reporter_role') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('reporter_role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- AKHIR DARI FIELD YANG DIASUMSIKAN BENAR --}}


                <hr class="my-4">

                {{-- Bagian Saksi --}}
                <div class="mb-3">
                    <label class="form-label">Apakah ada saksi dalam kejadian ini? <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('has_witness') is-invalid @enderror" type="radio" name="has_witness" id="witness_yes" value="yes" {{ old('has_witness') == 'yes' ? 'checked' : '' }} onclick="toggleWitnessFields(true)">
                            <label class="form-check-label" for="witness_yes">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('has_witness') is-invalid @enderror" type="radio" name="has_witness" id="witness_no" value="no" {{ old('has_witness', 'no') == 'no' ? 'checked' : '' }} onclick="toggleWitnessFields(false)">
                            <label class="form-check-label" for="witness_no">Tidak</label>
                        </div>
                        @error('has_witness')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="witness_fields" style="{{ old('has_witness') == 'yes' ? '' : 'display: none;' }}">
                    <div class="mb-3">
                        <label for="witness_name" class="form-label">Nama saksi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('witness_name') is-invalid @enderror" id="witness_name" name="witness_name"
                            placeholder="Isi nama saksi" value="{{ old('witness_name') }}"> {{-- Atribut diatur JS --}}
                        @error('witness_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="witness_relation" class="form-label">Status atau hubungan Anda dengan saksi <span class="text-danger">*</span></label>
                        <select class="form-select @error('witness_relation') is-invalid @enderror" id="witness_relation" name="witness_relation"> {{-- Atribut diatur JS --}}
                            <option value="" disabled {{ !old('witness_relation') ? 'selected' : '' }}>Pilih status/hubungan</option>
                            <option value="teman" {{ old('witness_relation') == 'teman' ? 'selected' : '' }}>Teman</option>
                            <option value="rekan_kerja" {{ old('witness_relation') == 'rekan_kerja' ? 'selected' : '' }}>Rekan Kerja/Studi</option>
                            <option value="keluarga" {{ old('witness_relation') == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                            <option value="tidak_kenal" {{ old('witness_relation') == 'tidak_kenal' ? 'selected' : '' }}>Tidak Kenal</option>
                            <option value="lainnya" {{ old('witness_relation') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('witness_relation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- Bagian Terlapor --}}
                <div class="mb-3">
                    <label class="form-label">Apakah Anda mengetahui identitas terlapor? <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('knows_perpetrator') is-invalid @enderror" type="radio" name="knows_perpetrator" id="perpetrator_yes" value="yes" {{ old('knows_perpetrator') == 'yes' ? 'checked' : '' }} onclick="togglePerpetratorFields(true)">
                            <label class="form-check-label" for="perpetrator_yes">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                             {{-- Logika checked untuk 'no' disederhanakan --}}
                            <input class="form-check-input @error('knows_perpetrator') is-invalid @enderror" type="radio" name="knows_perpetrator" id="perpetrator_no" value="no" {{ old('knows_perpetrator', 'no') == 'no' ? 'checked' : '' }} onclick="togglePerpetratorFields(false)">
                            <label class="form-check-label" for="perpetrator_no">Tidak</label>
                        </div>
                         @error('knows_perpetrator')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="perpetrator_fields" style="{{ old('knows_perpetrator') == 'yes' ? '' : 'display: none;' }}">
                    <div class="mb-3">
                        <label for="perpetrator_name" class="form-label">Nama terlapor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('perpetrator_name') is-invalid @enderror" id="perpetrator_name" name="perpetrator_name"
                            placeholder="Isi nama terlapor" value="{{ old('perpetrator_name') }}"> {{-- Atribut diatur JS --}}
                        @error('perpetrator_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="perpetrator_role" class="form-label">Status terlapor <span class="text-danger">*</span></label>
                        <select class="form-select @error('perpetrator_role') is-invalid @enderror" id="perpetrator_role" name="perpetrator_role"> {{-- Atribut diatur JS --}}
                            <option value="" disabled {{ !old('perpetrator_role') ? 'selected' : '' }}>Pilih status terlapor</option>
                            <option value="mahasiswa" {{ old('perpetrator_role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="staff" {{ old('perpetrator_role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="dosen" {{ old('perpetrator_role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="lainnya" {{ old('perpetrator_role') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            <option value="tidak_diketahui" {{ old('perpetrator_role') == 'tidak_diketahui' ? 'selected' : '' }}>Tidak Diketahui</option>
                        </select>
                        @error('perpetrator_role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ... field evidence dan agreement ... --}}
                {{-- Saya salin dari kode Anda sebelumnya, diasumsikan sudah benar --}}
                <hr class="my-4">

                <div class="mb-3">
                    <label for="evidence" class="form-label">Upload bukti pendukung (Format: pdf, doc, docx, jpg, png & Max: 2MB) <span class="text-danger">*</span></label>
                    <input class="form-control @error('evidence') is-invalid @enderror" type="file" id="evidence" name="evidence" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    @error('evidence')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <h5>Pernyataan dan Persetujuan</h5>
                    <p class="small">Dengan ini saya menyatakan bahwa informasi yang saya sampaikan dalam formulir ini adalah benar dan sesuai dengan pengetahuan saya.</p>
                    <p class="small mb-1">Saya menyetujui bahwa:</p>
                    <ul class="small">
                        <li>Data dan informasi yang saya berikan akan dijaga kerahasiaannya sesuai dengan prinsip perlindungan pelapor.</li>
                        <li>Saya berhak mendapatkan informasi lanjutan dan pendampingan jika dibutuhkan.</li>
                    </ul>
                    <div class="form-check">
                        <input class="form-check-input @error('agreement') is-invalid @enderror" type="checkbox" value="1" id="agreement" name="agreement" {{ old('agreement') ? 'checked' : '' }}>
                        <label class="form-check-label" for="agreement">
                            Saya menyetujui pernyataan di atas dan bersedia melanjutkan pengiriman laporan.
                        <span class="text-danger">*</span></label>
                        @error('agreement')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- AKHIR DARI FIELD YANG DIASUMSIKAN BENAR --}}


                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="window.history.back();">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        @else
            <div class="alert alert-warning">
                Harap <a href="{{ route('login') }}">login</a> untuk membuat laporan.
            </div>
        @endauth
    </div>
</div>
@endsection

@push('page-scripts')
    @vite('resources/js/report.js')
@endpush
