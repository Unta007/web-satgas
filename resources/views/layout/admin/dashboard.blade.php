<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-bars.css', 'resources/css/overview.css'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    <div class="d-flex">
        @include('layout.admin.sidebar')

        <div class="main-content-wrapper">
            @include('layout.admin.navbar')

            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Offcanvas Sidebar untuk Mobile --}}
    <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="sidebarOffcanvas"
        aria-labelledby="sidebarOffcanvasLabel" data-bs-theme="dark">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            {{-- Isi offcanvas sama dengan sidebar utama, bisa direfactor ke dalam satu partial view --}}
            {{-- Untuk sekarang kita duplikat saja --}}
            <ul class="nav nav-pills flex-column mt-4">
                {{-- ... salin semua <li class="nav-item"> dari sidebar utama ke sini ... --}}
            </ul>
        </div>
    </div>

    {{-- Script untuk Chart.js & lainnya --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('page-scripts')
</body>

</html>
