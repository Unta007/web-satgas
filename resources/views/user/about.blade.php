@extends('layout.app')

@section('title', 'Tentang Kami')

@section('content')

    @php
        $breadcrumbs = [['name' => 'Beranda', 'url' => route('home')], ['name' => 'Tentang Kami']];
    @endphp
    <x-hero title="Tentang Kami"
        subtitle="Memahami misi dan komitmen kami dalam menciptakan lingkungan yang aman, bermartabat, dan bebas dari kekerasan untuk seluruh civitas akademika."
        :breadcrumbs="$breadcrumbs" />

    <div class="container">
        <section class="about-section">
            <div class="vision-mission-grid">
                <div class="vm-card scroll-animate" style="transition-delay: 200ms;">
                    <div class="vm-card-header">
                        <i class="bi bi-eye-fill vm-card-icon"></i>
                        <h2>Visi</h2>
                    </div>
                    <p>
                        Menjadi pelopor dalam penciptaan ruang pendidikan yang inklusif, adil, dan aman, di mana setiap individu merasa dihargai, dihormati, dan bebas untuk mencapai potensi penuhnya tanpa rasa takut akan kekerasan dan diskriminasi.
                    </p>
                </div>

                {{-- KARTU MISI --}}
                <div class="vm-card scroll-animate" style="transition-delay: 300ms;">
                    <div class="vm-card-header">
                        <i class="bi bi-bullseye vm-card-icon"></i>
                        <h2>Misi</h2>
                    </div>
                    <p>
                        Secara proaktif melakukan edukasi, advokasi, dan implementasi kebijakan yang efektif untuk mencegah segala bentuk kekerasan, serta menyediakan layanan pendampingan yang responsif dan berpihak pada korban.
                    </p>
                </div>
            </div>
        </section>

        {{-- BAGIAN TUJUAN KAMI --}}
        <section class="about-section objectives-section scroll-animate" style="transition-delay: 400ms;">
            <div class="objectives-content">
                <div class="objectives-list">
                    <h2>Tujuan Kami</h2>
                    <p class="text-muted mb-4">
                        Sesuai dengan Permendikbudristek Nomor 30 Tahun 2021, tujuan kami adalah sebagai berikut:
                    </p>
                    <ul class="list-unstyled">
                        <li class="objective-item">
                            <i class="bi bi-shield-check objective-icon"></i>
                            <div>
                                <strong>Menjadi Pedoman</strong>
                                <p class="mb-0 text-muted small">Menyusun kebijakan dan tindakan pencegahan serta penanganan kekerasan seksual yang terstruktur dan efektif.</p>
                            </div>
                        </li>
                        <li class="objective-item">
                            <i class="bi bi-people-fill objective-icon"></i>
                            <div>
                                <strong>Menumbuhkan Kehidupan Kampus</strong>
                                <p class="mb-0 text-muted small">Menciptakan kampus yang manusiawi, bermartabat, setara, inklusif, dan bebas dari kekerasan untuk semua.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="objectives-image d-none d-lg-block">
                    {{-- Ganti dengan URL gambar yang relevan --}}
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Lingkungan Kampus yang Kolaboratif">
                </div>
            </div>
        </section>

        <section class="about-section text-center scroll-animate">
            <h2>Punya Pertanyaan atau Butuh Bantuan?</h2>
            <p class="lead text-muted">Tim kami siap membantu. Jangan ragu untuk menghubungi kami atau membuat laporan.</p>
            <div class="mt-4">
                <a href="{{ route('reports.index') }}" class="btn btn-danger btn-lg px-4 me-2">Laporkan Insiden</a>
                <a href="https://linktr.ee/satgasppks" class="btn btn-outline-secondary btn-lg px-4">Hubungi Kami</a>
            </div>
        </section>

    </div>
@endsection

@push('page-scripts')
    @vite('resources/js/scroll-animate.js')
@endpush
