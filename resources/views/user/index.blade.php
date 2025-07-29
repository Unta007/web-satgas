@extends('layout.app')

@section('title', 'Beranda')

@section('content')
    {{-- 1. HERO CAROUSEL --}}
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            {{-- Slide 1 --}}
            <div class="carousel-item active"
                style="background-image: url('{{ Vite::asset('resources/images/telkom.jpg') }}');">
                <div class="carousel-caption d-none d-md-block text-start">
                    <div class="caption-text container">
                        <h1 class="display-4 fw-bold">Kami Hadir Untuk Anda</h1>
                        <p class="lead col-lg-11">Satgas PPKPT hadir untuk menciptakan lingkungan kampus yang aman dan
                            bebas dari segala bentuk kekerasan. Kami siap membantu Anda.</p>
                        <div class="d-flex gap-2 mt-4">
                            <a class="btn btn-hero btn-danger" href="{{ route('reports.index') }}">Lapor Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 (Opsional) --}}
            <div class="carousel-item"
                style="background-image: url('{{ Vite::asset('resources/images/telkom-univ.jpg') }}');">
                <div class="carousel-caption d-none d-md-block text-start">
                    <div class="caption-text container">
                        <h1 class="display-4 fw-bold">Kampus yang Aman untuk Semua</h1>
                        <p class="lead col-lg-9">Edukasi adalah kunci. Mari bersama-sama belajar dan bertindak untuk
                            mencegah kekerasan.</p>
                        <a class="btn btn-hero btn-danger mt-3" href="/educational-contents">Lihat Materi Edukasi</a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    {{-- 2. SAMBUTAN KETUA --}}
    <section class="welcome-greetings py-5 fade-in-section">
        <div class="container my-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 text-center">
                    {{-- TODO: Ganti dengan FOTO PROFESIONAL Ketua Satgas. Ini sangat penting untuk membangun kepercayaan. --}}
                    <img src="{{ Vite::asset('resources/images/ketua_satgas.jpg') }}" alt="Foto Ketua Satgas PPKPT"
                        class="img-fluid rounded-circle shadow-lg"
                        style="max-width: 300px; height: 300px; object-fit: cover;" />
                </div>
                <div class="col-lg-7">
                    <h2 class="display-5 fw-bold mb-3">Sambutan Satgas PPKPT</h2>
                    <p class="lead text-muted">"Kami berkomitmen penuh untuk menciptakan lingkungan belajar yang aman,
                        nyaman, dan suportif bagi seluruh sivitas akademika. Satgas PPKPT hadir sebagai sahabat Anda, siap
                        mendengarkan, mendampingi, dan melindungi."</p>
                    <p>Jangan pernah ragu untuk menjangkau kami. Bersama, kita wujudkan budaya hormat dan martabat di
                        kampus kita tercinta.</p>
                    <p class="mt-3 fw-bold">Amalia Nur Alifah, S.Si., M.Si</p>
                    <p class="jabatan">Anggota Satgas PPKPT Kampus Surabaya</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. RUANG AMAN ANDA (PENGGANTI SEKSI LAPOR) --}}
    <section class="safe-space-section text-center py-5">
        <div class="container my-4 fade-in-section">
            <h2 class="display-5 fw-bold">Ruang Aman Anda untuk Bersuara</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Kami menyediakan beberapa jalur untuk memastikan
                Anda mendapatkan bantuan yang paling sesuai dengan kebutuhan Anda.
            </p>
            <div class="row g-4 mt-4 pt-3">
                {{-- Pilihan 1: Lapor Anonim --}}
                <div class="col-md-4">
                    <div class="action-card h-100 p-4">
                        <i class="bi bi-shield-shaded fs-1 text-danger mb-3"></i>
                        <h4 class="fw-bold">Laporkan Insiden</h4>
                        <p class="small">Segera lapor kepada kami apabila Anda apabila mengetahui adanya sebuah insiden.
                            Kami akan menindaklanjuti
                            setiap informasi yang masuk.</p>
                        <a href="/report" class="stretched-link"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="action-card h-100 p-4" style="cursor: pointer;" onclick="Tawk_API.maximize()">
                        <i class="bi bi-chat-dots-fill fs-1 text-danger mb-3"></i>
                        <h4 class="fw-bold">Forum Diskusi Aman</h4>
                        <p class="small">Butuh teman bicara sekarang? Terhubung langsung dengan tim kami secara pribadi dan
                            rahasia melalui live chat untuk mendapatkan dukungan segera.</p>
                    </div>
                </div>
                {{-- Pilihan 3: Kontak Darurat --}}
                <div class="col-md-4">
                    <div class="action-card h-100 p-4">
                        <i class="bi bi-telephone-fill fs-1 text-danger mb-3"></i>
                        <h4 class="fw-bold">Hubungi Kontak Darurat</h4>
                        <p class="small">Jika Anda berada dalam situasi mendesak dan membutuhkan bantuan segera, hubungi
                            jalur cepat kami.</p>
                        <a href="/emergency-contacts" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. KONTEN EDUKASI --}}
    <section class="educational-content py-5 fade-in-section">
        <div class="container my-4">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Pusat Pengetahuan</h2>
                <p class="lead text-muted">Jelajahi koleksi artikel dan sumber daya edukasi terbaru kami.</p>
            </div>

            {{-- Cek apakah ada artikel untuk ditampilkan --}}
            @if ($latestArticles->isNotEmpty())
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    {{-- Lakukan perulangan untuk setiap artikel --}}
                    @foreach ($latestArticles as $article)
                        <div class="col">
                            <div class="card h-100 shadow-sm educational-card">
                                {{-- Gambar Artikel (dengan fallback) --}}
                                <a href="{{ route('articles.show', $article->slug) }}" class="card-img-container">
                                    <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/400x250/A40E0E/FFFFFF?text=Edukasi' }}"
                                        class="card-img-top" alt="{{ $article->title }}">
                                </a>

                                <div class="card-body d-flex flex-column">
                                    {{-- Judul Artikel --}}
                                    <h5 class="card-title">
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="text-decoration-none text-dark stretched-link">
                                            {{ $article->title }}
                                        </a>
                                    </h5>

                                    {{-- Deskripsi Singkat --}}
                                    <p class="card-text flex-grow-1">
                                        {{-- Batasi deskripsi agar panjangnya konsisten --}}
                                        {{ Str::limit(strip_tags($article->description), 120) }}
                                    </p>

                                    {{-- Tombol Baca Selengkapnya tidak diperlukan karena seluruh kartu bisa diklik --}}
                                    {{-- Stretched-link pada judul membuat seluruh kartu bisa di-klik --}}
                                </div>
                                <div class="card-footer bg-transparent border-0 pb-3">
                                    <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('articles.index') }}" class="btn btn-danger">Lihat Semua Artikel</a>
                </div>
            @else
                {{-- Tampilkan pesan ini jika tidak ada artikel sama sekali di database --}}
                <div class="text-center text-muted">
                    <p>Saat ini belum ada konten edukasi yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- 5. TESTIMONI --}}
    <section class="testimonial-section py-5 fade-in-section">
        <div class="container my-4">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Kisah Mereka yang Telah Kami Dampingi</h2>
                <p class="lead text-muted">Pengalaman nyata yang menunjukkan pentingnya dukungan bersama.</p>
            </div>

            {{-- Cek apakah ada testimoni untuk ditampilkan --}}
            @if ($testimonials->isNotEmpty())
                <div id="testimonialSlider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        {{-- Lakukan perulangan untuk setiap testimoni --}}
                        @foreach ($testimonials as $testimonial)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="testimonial-card">
                                    <p class="testimonial-quote">"{{ $testimonial->quote }}"</p>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Tombol navigasi carousel hanya ditampilkan jika ada lebih dari 1 testimoni --}}
                    @if ($testimonials->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialSlider"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialSlider"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            @endif

        </div>
    </section>

    <button id="backToTopBtn" title="Kembali ke Atas" aria-label="Kembali ke Atas">
        <i class="bi bi-arrow-up"></i>
    </button>

@endsection
