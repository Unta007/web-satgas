<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container-fluid">
        {{-- Tombol untuk memunculkan sidebar di layar kecil --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"
            aria-controls="sidebarOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- User Dropdown --}}
        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://i.pravatar.cc/150?u={{ Auth::id() }}" alt="" width="32" height="32"
                    class="rounded-circle me-2">
                <strong>{{ auth()->user()->username }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                <li><a class="dropdown-item" href="{{ route('home') }}">Board Index</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
