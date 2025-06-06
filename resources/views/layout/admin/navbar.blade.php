<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container-fluid">
        {{-- Tombol untuk memunculkan sidebar di layar kecil --}}
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"
            aria-controls="sidebarOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- User Dropdown --}}
        <div class="dropdown ms-auto">
            <a href="#" class="nav-profile d-flex align-items-center text-decoration-none dropdown-toggle no-arrow"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil" width="31" height="31"
                    class="rounded-circle me-2" style="object-fit: cover;">
                <strong>{{ auth()->user()->username }}</strong>
                <i class="icon-navbar bi bi-chevron-down ms-2"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                <li><a class="dropdown-item" href="{{ route('home') }}">
                    <i class="bi bi-house-fill me-2"></i>Board Index</a>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="bi bi-person-fill me-2"></i>My Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left me-2"></i>Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
