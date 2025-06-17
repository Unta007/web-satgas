@extends('layout.app')

@section('title', 'Beranda')

@section('content')
    {{-- 1. HERO CAROUSEL --}}
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            {{-- Slide 1 --}}
            {{-- TODO: Ganti gambar dengan yang lebih humanis dan suportif --}}
            <div class="carousel-item active"
                style="background-image: url('{{ Vite::asset('resources/images/telkom.jpg') }}');">
                <div class="carousel-caption d-none d-md-block text-start">
                    <div class="caption-text container">
                        <h1 class="display-4 fw-bold">Kami Hadir Untuk Anda</h1>
                        <p class="lead col-lg-11">Satgas PPKS hadir untuk menciptakan lingkungan kampus yang aman dan
                            bebas dari kekerasan seksual. Kami siap membantu Anda.</p>
                        <div class="d-flex gap-2 mt-4">
                            <a class="btn btn-hero btn-danger" href="{{ route('reports.index') }}">Lapor Sekarang</a>
                            <a class="btn btn-hero btn-outline-light" href="/pusat-informasi">Cari Bantuan & Informasi</a>
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
                    <img src="{{ Vite::asset('resources/images/avatar.jpg') }}" alt="Foto Ketua Satgas PPKS"
                        class="img-fluid rounded-circle shadow-lg"
                        style="max-width: 300px; height: 300px; object-fit: cover;" />
                </div>
                <div class="col-lg-7">
                    <h2 class="display-5 fw-bold mb-3">Sambutan Ketua Satgas PPKS</h2>
                    <p class="lead text-muted">"Kami berkomitmen penuh untuk menciptakan lingkungan belajar yang aman,
                        nyaman, dan suportif bagi seluruh sivitas akademika. Satgas PPKS hadir sebagai sahabat Anda, siap
                        mendengarkan, mendampingi, dan melindungi."</p>
                    <p>Jangan pernah ragu untuk menjangkau kami. Bersama, kita wujudkan budaya hormat dan martabat di
                        kampus kita tercinta.</p>
                    <p class="mt-3 fw-bold">Amalia Nur Alifah, S.Psi., M.Si.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. RUANG AMAN ANDA (PENGGANTI SEKSI LAPOR) --}}
    <section class="safe-space-section text-center py-5">
        <div class="container my-4 fade-in-section">
            <h2 class="display-5 fw-bold">Ruang Aman Anda untuk Bersuara</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Kami menyediakan beberapa jalur untuk memastikan
                Anda mendapatkan bantuan yang paling sesuai dengan kebutuhan Anda. Privasi Anda adalah prioritas kami.
            </p>
            <div class="row g-4 mt-4 pt-3">
                {{-- Pilihan 1: Lapor Anonim --}}
                <div class="col-md-4">
                    <div class="action-card h-100 p-4">
                        <i class="bi bi-shield-shaded fs-1 text-danger mb-3"></i>
                        <h4 class="fw-bold">Lapor Secara Anonim</h4>
                        <p class="small">Kirimkan laporan Anda tanpa perlu menyertakan identitas. Kami akan menindaklanjuti
                            setiap informasi yang masuk.</p>
                        <a href="/lapor-anonim" class="stretched-link"></a>
                    </div>
                </div>
                {{-- Pilihan 2: Jadwalkan Konsultasi --}}
                <div class="col-md-4">
                    <div class="action-card h-100 p-4">
                        <i class="bi bi-calendar-event fs-1 text-danger mb-3"></i>
                        <h4 class="fw-bold">Jadwalkan Konsultasi</h4>
                        <p class="small">Bicarakan pengalaman Anda secara pribadi dan rahasia dengan tim kami yang
                            terlatih untuk memberikan pendampingan.</p>
                        <a href="/konsultasi" class="stretched-link"></a>
                    </div>
                </div>
                {{-- Pilihan 3: Kontak Darurat --}}
                <div class="col-md-4">
                    <div class="action-card h-100 p-4">
                        <i class="bi bi-telephone-fill fs-1 text-danger mb-3"></i>
                        <h4 class="fw-bold">Hubungi Kontak Darurat</h4>
                        <p class="small">Jika Anda berada dalam situasi mendesak dan membutuhkan bantuan segera, hubungi
                            jalur cepat kami.</p>
                        <a href="/kontak-darurat" class="stretched-link"></a>
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
                <p class="lead text-muted">Jelajahi koleksi artikel dan sumber daya edukasi kami.</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                {{-- TODO: Ganti gambar dengan ilustrasi/grafik yang relevan dan konsisten --}}
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ Vite::asset('resources/images/report.jpg') }}" class="card-img-top"
                            alt="Ilustrasi Pelaporan Efektif">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Pelaporan yang Efektif</h5>
                            <p class="card-text flex-grow-1">Pahami apa saja yang termasuk kekerasan seksual dan bagaimana
                                cara mengenalinya di berbagai lingkungan.</p>
                            <a href="#" class="btn btn-danger mt-auto align-self-start">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ Vite::asset('resources/images/mental.jpg') }}" class="card-img-top"
                            alt="Ilustrasi Dampak Psikologis">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Memahami Dampak Psikologis</h5>
                            <p class="card-text flex-grow-1">Ketahui dampak psikologis yang dapat dialami korban dan
                                pentingnya dukungan kesehatan mental.</p>
                            <a href="#" class="btn btn-danger mt-auto align-self-start">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ Vite::asset('resources/images/prevention.jpg') }}" class="card-img-top"
                            alt="Ilustrasi Strategi Pencegahan">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Strategi Pencegahan</h5>
                            <p class="card-text flex-grow-1">Jelajahi strategi dan praktik terbaik untuk mencegah
                                kekerasan seksual di komunitas Anda.</p>
                            <a href="#" class="btn btn-danger mt-auto align-self-start">Lihat Strategi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. TESTIMONI --}}
    <section class="testimonial-section py-5 fade-in-section">
        <div class="container my-4">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Kisah Mereka yang Telah Kami Dampingi</h2>
                <p class="lead text-muted">Pengalaman nyata yang menunjukkan pentingnya dukungan bersama.</p>
            </div>
            <div id="testimonialSlider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="testimonial-card">
                            <p class="testimonial-quote">"Saya merasa didengarkan dan didukung penuh selama proses
                                pelaporan. Saya tidak merasa dihakimi sama sekali. Terima kasih Satgas PPKS."</p>
                            <p class="testimonial-author">— Mahasiswi, Fakultas Informatika</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card">
                            <p class="testimonial-quote">"Timnya sangat profesional, berempati, dan efektif. Sumber daya
                                yang sangat berharga bagi siapa pun yang membutuhkan bantuan."</p>
                            <p class="testimonial-author">— Mahasiswa, Fakultas Teknik Elektro</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card">
                            <p class="testimonial-quote">"Layanan ini menyelamatkan saya. Dukungan dan sumber daya yang
                                diberikan sungguh luar biasa. Saya jadi berani untuk melanjutkan studi."</p>
                            <p class="testimonial-author">— Anonim</p>
                        </div>
                    </div>
                </div>
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
            </div>
        </div>
    </section>

    <button id="backToTopBtn" title="Kembali ke Atas" aria-label="Kembali ke Atas">&#8679;</button>

@endsection
