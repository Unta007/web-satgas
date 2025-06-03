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
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
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
            {{-- Contoh Submenu menggunakan Collapse --}}
            <a class="nav-link" data-bs-toggle="collapse" href="#reportsCollapse" role="button" aria-expanded="false"
                aria-controls="reportsCollapse">
                <i class="bi bi-file-earmark-text-fill me-2"></i> Reports List <i
                    class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="reportsCollapse">
                <div class="submenu">
                    <a href="{{ route('admin.reports.unread') }}" class="nav-link {{ Request::is('admin/reports/unread*') ? 'active' : '' }}">Unread</a>
                    <a href="{{ route('admin.reports.review') }}" class="nav-link {{ Request::is('admin/reports/review*') ? 'active' : '' }}">Review</a>
                    <a href="{{ route('admin.reports.ongoing') }}" class="nav-link {{ Request::is('admin/reports/ongoing*') ? 'active' : '' }}">Ongoing</a>
                    <a href="{{ route('admin.reports.solved') }}" class="nav-link {{ Request::is('admin/reports/solved*') ? 'active' : '' }}}">Solved</a>
                    <a href="{{ route('admin.reports.denied') }}" class="nav-link {{ Request::is('admin/reports/denied*') ? 'active' : '' }}">Denied</a>
                    <a href="#" class="nav-link">Archived</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-journal-text me-2"></i> Articles
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-person-badge-fill me-2"></i> Manage Staff
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-eye-fill me-2"></i> View Log
            </a>
        </li>
    </ul>
</nav>
