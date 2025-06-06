<nav class="sidebar sidebar-custom-background d-none d-lg-block" data-bs-theme="dark">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ Vite::asset('resources/images/tel-u_putih.png') }}" alt="Logo" width="150" height="62">
        </a>
    </div>
    @include('layout.admin.sidebar-content')
</nav>
