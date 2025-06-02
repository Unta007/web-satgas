<nav id="navbar-home" class="navbar navbar-expand-lg"> {{-- Pastikan ID/kelas ini memberikan style background maroon dan teks putih --}}
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ Vite::asset('resources/images/tel-u_putih.png') }}" alt="Logo Telkom University Surabaya"
                width="125" height="50" /> {{-- Alt text diperjelas --}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> {{-- Pastikan ikon ini terlihat di background maroon --}}
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                {{-- Sesuaikan href dengan route('nama.rute') jika memungkinkan --}}
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                    href="{{ route('home') }}">Beranda</a>
                <a class="nav-link {{ request()->is('educational-contents*') ? 'active' : '' }}"
                    href="/educational-contents">Laman Edukasi</a>
                <a class="nav-link {{ request()->is('reports/create*') || request()->is('report/submit*') ? 'active' : '' }}"
                    href="{{ route('reports.index') }}">Pelaporan</a> {{-- Menggunakan nama rute dari contoh sebelumnya --}}
                <a class="nav-link {{ request()->is('about-us*') ? 'active' : '' }}" href="/about-us">Tentang Kami</a>
            </div>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                @auth
                    {{-- ==== NOTIFICATION DROPDOWN START ==== --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarNotificationDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
                            <i class="bi bi-bell-fill fs-5 position-relative">
                                {{-- Opsional: Badge untuk jumlah notifikasi belum dibaca --}}
                                {{-- Ganti angka '3' dengan jumlah notifikasi belum dibaca dari backend --}}
                                @php $unreadNotificationsCount = 0; /* Contoh, ambil dari backend */ @endphp
                                @if (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size:0.6rem; padding: .25rem .4rem !important;">
                                        {{ $unreadNotificationsCount }}
                                        <span class="visually-hidden">notifikasi baru</span>
                                    </span>
                                @endif
                            </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown-menu shadow border-0 mt-2"
                            aria-labelledby="navbarNotificationDropdown">
                            <li>
                                <div class="dropdown-header notification-header">
                                    <h6 class="mb-0 fw-bold">Notification</h6>
                                    {{-- <a href="#" class="small text-decoration-none ms-auto">Tandai semua terbaca</a> --}}
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-0">
                            </li>

                            {{-- Contoh Item Notifikasi 1 (Belum Dibaca) --}}
                            {{-- Ganti dengan loop dan data dari backend --}}
                            
                            {{-- Contoh Item Notifikasi 2 (Sudah Dibaca) --}}

                            <li>
                                <hr class="dropdown-divider my-0">
                            </li>
                            <li>
                                <a class="dropdown-item text-center small text-muted py-2 view-all-notifications"
                                    href="#">
                                    Lihat semua notifikasi
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- ==== NOTIFICATION DROPDOWN END ==== --}}

                    <li class="nav-item dropdown ms-lg-2"> {{-- ms-lg-2 untuk jarak di layar besar --}}
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUserDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 me-1"></i>
                            {{ auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            aria-labelledby="navbarUserDropdown">
                            {{-- <li><a class="dropdown-item" href="#"><i
                                        class="bi bi-person-fill me-2"></i>Profil Saya</a></li> --}}

                            {{-- ==== LINK DASHBOARD ADMIN (KONDISIONAL) ==== --}}
                            @if(auth()->user()->hasAdminAccess())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                            class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                            @endif
                            {{-- ==== AKHIR LINK DASHBOARD ADMIN ==== --}}

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i
                                            class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
