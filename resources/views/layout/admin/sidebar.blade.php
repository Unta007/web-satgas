<nav class="sidebar" data-bs-theme="dark">
    {{-- Logo --}}
    <div class="sidebar-header">
        <a href="#" class="navbar-brand">
            {{-- Ganti dengan logo Anda --}}
            <img src="{{ Vite::asset('resources/images/tel-u_putih.png') }}" alt="Logo" width="125" height="50">
        </a>
    </div>

    {{-- Menu --}}
    <ul class="nav nav-pills flex-column mt-4">
        <li class="nav-item">
            <small class="nav-link-header">Dashboard</small>
        </li>
        <li class="nav-item">
            {{-- Tambahkan class 'active' jika halaman ini sedang aktif --}}
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill me-2"></i> Overview
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.charts.index') }}"
                class="nav-link {{ Request::is('admin/charts*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line-fill me-2"></i> Grafik
            </a>
        </li>

        <li class="nav-item mt-3">
            <small class="nav-link-header">Pages</small>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#reportsCollapse" role="button" aria-expanded="false"
                aria-controls="reportsCollapse">
                <i class="bi bi-file-earmark-text-fill me-2"></i> Reports List <i
                    class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse {{ Request::is('admin/reports*') ? 'show' : '' }}" id="reportsCollapse">
                <div class="submenu">
                    <a href="{{ route('admin.reports.unread') }}"
                        class="nav-link {{ Request::is('admin/reports/unread*') ? 'active' : '' }}">Unread</a>
                    <a href="{{ route('admin.reports.review') }}"
                        class="nav-link {{ Request::is('admin/reports/review*') ? 'active' : '' }}">Review</a>
                    <a href="{{ route('admin.reports.ongoing') }}"
                        class="nav-link {{ Request::is('admin/reports/ongoing*') ? 'active' : '' }}">Ongoing</a>
                    <a href="{{ route('admin.reports.solved') }}"
                        class="nav-link {{ Request::is('admin/reports/solved*') ? 'active' : '' }}}">Solved</a>
                    <a href="{{ route('admin.reports.denied') }}"
                        class="nav-link {{ Request::is('admin/reports/denied*') ? 'active' : '' }}">Denied</a>
                    <a href="{{ route('admin.reports.archived') }}"
                        class="nav-link {{ Request::is('admin/reports/archived*') ? 'active' : '' }}">Archived</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#articlesCollapse" role="button" aria-expanded="false"
                aria-controls="articlesCollapse">
                <i class="bi bi-newspaper me-2"></i> Artikel <i class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse {{ Request::is('admin/articles*') ? 'show' : '' }}" id="articlesCollapse">
                <div class="submenu">
                    <a href="{{ route('admin.articles.index') }}"
                        class="nav-link {{ Request::is('admin/articles') && !Request::is('admin/articles/create') ? 'active' : '' }}">
                        List Artikel
                    </a>
                    <a href="{{ route('admin.articles.create') }}"
                        class="nav-link {{ Request::is('admin/articles/create') ? 'active' : '' }}">
                        Tambah Artikel
                    </a>
                </div>
            </div>
        </li>
        @if (Auth::check() && Auth::user()->isGlobalAdmin())
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#usersCollapse"
                    aria-expanded="{{ Request::is('admin/users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                    <i class="bi bi-people-fill me-2"></i>
                    <span>Kelola Staff</span>
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <div class="collapse {{ Request::is('admin/users*') ? 'show' : '' }}" id="usersCollapse"
                    data-bs-parent="#sidebar-nav">
                    <div class="submenu">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ Request::is('admin/users') && !Request::is('admin/users/create') ? 'active' : '' }}">
                            List Staff
                        </a>
                        <a href="{{ route('admin.users.create') }}"
                            class="nav-link {{ Request::is('admin/users/create') ? 'active' : '' }}">
                            Tambah Staff
                        </a>
                    </div>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}"
                href="{{ route('admin.logs.index') }}">
                <i class="bi bi-terminal-fill me-2"></i> View Log
            </a>
        </li>
    </ul>
</nav>
