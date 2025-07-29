@extends('layout.app')

@section('title', 'Tentang Kami')

@section('content')

    @php
        $breadcrumbs = [['name' => 'Beranda', 'url' => route('home')], ['name' => 'Tentang Kami']];
    @endphp
    <x-hero title="Tentang Kami"
        subtitle="Satuan Tugas Pencegahan dan Penanganan Kekerasan di Perguruan Tinggi (Satgas PPKPT) Telkom University Surabaya berkomitmen menciptakan lingkungan kampus yang aman, bermartabat, dan bebas dari segala bentuk kekerasan."
        :breadcrumbs="$breadcrumbs" />

    <div class="container">
        {{-- BAGIAN DASAR HUKUM --}}
        <section class="about-section scroll-animate" style="transition-delay: 100ms;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-3">Dasar Hukum</h2>
                    <p class="lead text-muted" style="text-align: justify;">
                        Satgas PPKPT Telkom University Surabaya dibentuk berdasarkan <strong>Permendikbudristek Nomor 55 Tahun 2024</strong> tentang Pencegahan dan Penanganan Kekerasan di Lingkungan Perguruan Tinggi.
                    </p>
                    <p style="text-align: justify;">
                        Peraturan ini mengamanatkan setiap perguruan tinggi untuk membentuk Satuan Tugas yang bertugas membantu pimpinan perguruan tinggi dalam menyusun pedoman, melakukan sosialisasi, menerima laporan, dan menangani kasus kekerasan di lingkungan kampus.
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="p-4 bg-light rounded">
                        <i class="bi bi-book-fill display-1 text-danger mb-3"></i>
                        <h5>Permendikbudristek 55/2024</h5>
                        <small class="text-muted">Landasan Hukum PPKPT</small>
                        <a href="https://peraturan.bpk.go.id/Details/305767/permendikbudriset-no-55-tahun-2024" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </section>

        {{-- BAGIAN TUJUAN --}}
        <section class="about-section objectives-section scroll-animate" style="transition-delay: 200ms;">
            <div class="objectives-content">
                <div class="objectives-list">
                    <h2>Tujuan Satgas PPKPT</h2>
                    <p class="text-muted mb-4">
                        Sesuai dengan Permendikbudristek Nomor 55 Tahun 2024, tujuan pembentukan Satgas PPKPT adalah:
                    </p>
                    <ul class="list-unstyled">
                        <li class="objective-item">
                            <i class="bi bi-shield-check objective-icon"></i>
                            <div>
                                <strong>Mencegah Terjadinya Kekerasan</strong>
                                <p class="mb-0 text-muted small">Warga Kampus, Perguruan Tinggi, dan Mitra Perguruan Tinggi mampu mencegah terjadinya Kekerasan di lingkungan Perguruan Tinggi.</p>
                            </div>
                        </li>
                        <li class="objective-item">
                            <i class="bi bi-megaphone-fill objective-icon"></i>
                            <div>
                                <strong>Memfasilitasi Pelaporan</strong>
                                <p class="mb-0 text-muted small">Warga Kampus, Perguruan Tinggi, dan Mitra Perguruan Tinggi mampu untuk melaporkan Kekerasan yang dialami dan/atau diketahuinya.</p>
                            </div>
                        </li>
                        <li class="objective-item">
                            <i class="bi bi-heart-fill objective-icon"></i>
                            <div>
                                <strong>Menyediakan Bantuan</strong>
                                <p class="mb-0 text-muted small">Warga Kampus, Perguruan Tinggi, dan Mitra Perguruan Tinggi mampu mencari dan mendapatkan bantuan ketika mengalami Kekerasan.</p>
                            </div>
                        </li>
                        <li class="objective-item">
                            <i class="bi bi-people-fill objective-icon"></i>
                            <div>
                                <strong>Memberikan Penanganan Menyeluruh</strong>
                                <p class="mb-0 text-muted small">Warga Kampus dan Mitra Perguruan Tinggi yang mengalami Kekerasan segera mendapatkan Penanganan dan bantuan yang menyeluruh.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="objectives-image d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Lingkungan Kampus yang Aman">
                </div>
            </div>
        </section>

        {{-- BAGIAN PRINSIP KERJA --}}
        <section class="about-section scroll-animate" style="transition-delay: 300ms;">
            <h2 class="text-center mb-4">Prinsip Kerja Satgas PPKPT</h2>
            <p class="text-center text-muted mb-5">
                Dalam menjalankan tugasnya, Satgas PPKPT berpegang pada prinsip-prinsip berikut:
            </p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="principle-card h-100">
                        <div class="principle-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5>Nondiskriminasi & Kesetaraan</h5>
                        <p class="small text-muted">Menerapkan prinsip nondiskriminasi, keadilan dan kesetaraan gender, serta kesetaraan hak dan aksesibilitas bagi penyandang disabilitas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="principle-card h-100">
                        <div class="principle-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h5>Kepentingan Terbaik Korban</h5>
                        <p class="small text-muted">Mengutamakan kepentingan terbaik bagi korban dengan pendekatan yang penuh kehati-hatian dan konsisten.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="principle-card h-100">
                        <div class="principle-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5>Akuntabilitas & Independen</h5>
                        <p class="small text-muted">Bekerja secara akuntabel dan independen dengan jaminan ketidakberulangan serta keberlanjutan pendidikan.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- BAGIAN BENTUK KEKERASAN --}}
        <section class="about-section scroll-animate" style="transition-delay: 400ms;">
            <h2 class="text-center mb-4">Bentuk Kekerasan yang Ditangani</h2>
            <p class="text-center text-muted mb-5">
                Satgas PPKPT menangani berbagai bentuk kekerasan sesuai dengan klasifikasi dalam Permendikbudristek 55/2024:
            </p>
            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <div class="violence-type-card">
                        <i class="bi bi-person-x-fill"></i>
                        <h6>Kekerasan Fisik</h6>
                        <small class="text-muted">Tawuran, penganiayaan, perkelahian, eksploitasi ekonomi, dan lainnya</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="violence-type-card">
                        <i class="bi bi-emoji-frown-fill"></i>
                        <h6>Kekerasan Psikis</h6>
                        <small class="text-muted">Pengucilan, penghinaan, intimidasi, teror, pemerasan, dan lainnya</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="violence-type-card">
                        <i class="bi bi-arrow-repeat"></i>
                        <h6>Perundungan</h6>
                        <small class="text-muted">Pola perilaku kekerasan berulang dengan ketimpangan relasi kuasa</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="violence-type-card">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <h6>Kekerasan Seksual</h6>
                        <small class="text-muted">Perbuatan merendahkan, melecehkan tubuh dan fungsi reproduksi</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="violence-type-card">
                        <i class="bi bi-ban-fill"></i>
                        <h6>Diskriminasi</h6>
                        <small class="text-muted">Pembedaan berdasarkan suku, agama, ras, gender, dan lainnya</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="violence-type-card">
                        <i class="bi bi-file-earmark-x-fill"></i>
                        <h6>Kebijakan Kekerasan</h6>
                        <small class="text-muted">Kebijakan yang berpotensi menimbulkan kekerasan</small>
                    </div>
                </div>
            </div>
        </section>

        {{-- BAGIAN TUGAS SATGAS --}}
        <section class="about-section scroll-animate" style="transition-delay: 500ms;">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-4">Tugas dan Fungsi Satgas</h2>
                    <div class="task-list">
                        <div class="task-item">
                            <div class="task-number">01</div>
                            <div>
                                <h6>Penyusunan Pedoman</h6>
                                <p class="small text-muted mb-0">Membantu Pemimpin Perguruan Tinggi menyusun pedoman Pencegahan dan Penanganan Kekerasan.</p>
                            </div>
                        </div>
                        <div class="task-item">
                            <div class="task-number">02</div>
                            <div>
                                <h6>Sosialisasi dan Edukasi</h6>
                                <p class="small text-muted mb-0">Melakukan sosialisasi mengenai kesetaraan gender, hak disabilitas, dan pencegahan kekerasan.</p>
                            </div>
                        </div>
                        <div class="task-item">
                            <div class="task-number">03</div>
                            <div>
                                <h6>Penerimaan Laporan</h6>
                                <p class="small text-muted mb-0">Menerima dan menindaklanjuti laporan dugaan kekerasan dari warga kampus.</p>
                            </div>
                        </div>
                        <div class="task-item">
                            <div class="task-number">04</div>
                            <div>
                                <h6>Penanganan Kasus</h6>
                                <p class="small text-muted mb-0">Menindaklanjuti dan menangani temuan dugaan kekerasan sesuai prosedur.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="statistics-card">
                        <h5 class="mb-3">Data Penanganan Kekerasan Nasional</h5>
                        <p class="small text-muted mb-4">Berdasarkan data Kemendikbudristek 2021-2024:</p>
                        <div class="stat-item">
                            <div class="stat-number">338</div>
                            <div class="stat-label">Total Kasus Ditangani</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-number text-danger">160</div>
                                    <div class="mini-stat-label">Kekerasan Seksual</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-number text-warning">142</div>
                                    <div class="mini-stat-label">Perundungan</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-number text-info">36</div>
                                    <div class="mini-stat-label">Intoleransi</div>
                                </div>
                            </div>
                        </div>
                        <p class="small text-muted mt-3 mb-0">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            74% kasus kekerasan seksual di perguruan tinggi menunjukkan pentingnya peran Satgas PPKPT.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CALL TO ACTION --}}
        <section class="about-section text-center scroll-animate">
            <h2>Butuh Bantuan atau Ingin Melaporkan Insiden?</h2>
            <p class="lead text-muted">Tim Satgas PPKPT Telkom University Surabaya siap membantu Anda. Setiap laporan akan ditangani dengan kerahasiaan dan profesionalisme tinggi.</p>
            <div class="mt-4">
                <a href="{{ route('reports.index') }}" class="btn btn-danger btn-lg px-4 me-2">
                    <i class="bi bi-shield-exclamation me-2"></i>Laporkan Insiden
                </a>
                <a href="/emergency-contacts" class="btn btn-outline-secondary btn-lg px-4">
                    <i class="bi bi-telephone-fill me-2"></i>Hubungi Kami
                </a>
            </div>
            <div class="mt-4">
                <small class="text-muted">
                    <i class="bi bi-lock-fill me-1"></i>
                    Semua informasi akan dijaga kerahasiaannya sesuai dengan prosedur yang berlaku
                </small>
            </div>
        </section>

    </div>

    <button id="backToTopBtn" title="Kembali ke Atas" aria-label="Kembali ke Atas">
        <i class="bi bi-arrow-up"></i>
    </button>
    
@endsection

@push('page-scripts')
    @vite('resources/js/scroll-animate.js')
@endpush
