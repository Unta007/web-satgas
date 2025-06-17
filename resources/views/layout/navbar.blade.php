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
                    href="/educational-contents">Pusat Pengetahuan</a>
                <a class="nav-link {{ request()->is('report*') || request()->is('report/submit*') ? 'active' : '' }}"
                    href="{{ route('reports.index') }}">Buat Laporan</a>
                <a class="nav-link {{ request()->is('about-us*') ? 'active' : '' }}" href="/about-us">Tentang Kami</a>
            </div>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarNotificationDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
                            <i class="bi bi-bell-fill fs-5 position-relative">
                                @if (isset($unreadUserNotificationsCount) && $unreadUserNotificationsCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size:0.6rem; padding: .25rem .4rem !important;">
                                        {{ $unreadUserNotificationsCount }}
                                        <span class="visually-hidden">notifikasi baru</span>
                                    </span>
                                @endif
                            </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown-menu shadow border-0 mt-2"
                            aria-labelledby="navbarNotificationDropdown"
                            style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                            <li>
                                <div
                                    class="dropdown-header notification-header d-flex justify-content-between align-items-center px-3 py-2">
                                    <h6 class="mb-0 fw-bold">Notifikasi</h6>
                                    @if ($unreadUserNotificationsCount > 0)
                                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST"
                                            class="d-inline mark-all-read-form">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-link small text-decoration-none p-0 m-0 align-baseline">Tandai
                                                semua terbaca</button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-0">
                            </li>

                            @if (isset($userNotifications) && $userNotifications->count() > 0)
                                @foreach ($userNotifications as $notification)
                                    <li>
                                        <a class="dropdown-item notification-item {{ $notification->read_at ? 'read' : 'unread' }} px-3 py-2"
                                            href="{{ route('notifications.show', $notification->id) }}"
                                            {{-- Akan mengarah ke laporan & tandai terbaca --}} data-notification-id="{{ $notification->id }}">
                                            <div class="d-flex align-items-start">
                                                <div class="me-2 mt-1">
                                                    {{-- Ikon berdasarkan status atau tipe notifikasi --}}
                                                    @php
                                                        $iconClass = 'bi-info-circle-fill text-primary'; // Default
                                                        if (isset($notification->data['new_status'])) {
                                                            switch (strtolower($notification->data['new_status'])) {
                                                                case 'review':
                                                                    $iconClass = 'bi-search text-info';
                                                                    break;
                                                                case 'ongoing':
                                                                    $iconClass = 'bi-hourglass-split text-warning';
                                                                    break;
                                                                case 'solved':
                                                                    $iconClass = 'bi-check-circle-fill text-success';
                                                                    break;
                                                                case 'denied':
                                                                    $iconClass = 'bi-x-circle-fill text-danger';
                                                                    break;
                                                            }
                                                        }
                                                    @endphp
                                                    <i class="bi {{ $iconClass }}"></i>
                                                </div>
                                                <div class="notification-content">
                                                    <p class="mb-0 small lh-sm">
                                                        {!! $notification->data['message_html'] ?? ($notification->data['message_raw'] ?? 'Notifikasi baru.') !!}
                                                    </p>
                                                    <small
                                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <p class="text-center text-muted small py-3 mb-0">Tidak ada notifikasi baru.</p>
                                </li>
                            @endif

                            <li>
                                <hr class="dropdown-divider my-0">
                            </li>
                            <li>
                                <a class="dropdown-item text-center small text-muted py-2 view-all-notifications"
                                    href="{{ route('notifications.index') }}"> {{-- Ganti dengan route halaman semua notifikasi --}}
                                    Lihat semua notifikasi
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- ==== NOTIFICATION DROPDOWN END ==== --}}

                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center dropdown-toggle no-arrow"
                            href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil" class="rounded-circle me-2"
                                width="28" height="28" style="object-fit: cover;">
                            {{ auth()->user()->username }}
                            <i class="icon-navbar bi bi-chevron-down ms-2"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            aria-labelledby="navbarUserDropdown">

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="bi bi-person-fill me-2"></i>Profil Saya
                                </a>
                            </li>


                            @if (auth()->user()->hasAdminAccess())
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                            class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                            @endif
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
