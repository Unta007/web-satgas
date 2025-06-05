<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/admin-alerts.js', 'resources/js/admin-articles.js', 'resources/js/tinymce.js', 'resources/css/admin-bars.css', 'resources/css/overview.css', 'resources/css/charts.css', 'resources/css/admin-tables.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
</head>

<body>

    <div id="laravelSessionMessages" style="display: none;"
        @if (session('success')) data-success-message="{{ session('success') }}" @endif
        @if (session('error')) data-error-message="{{ session('error') }}" @endif
        @if (session('warning')) data-warning-message="{{ session('warning') }}" @endif
        @if (session('info')) data-info-message="{{ session('info') }}" @endif>
    </div>

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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tiny.cloud/1/53vzc8nx3b3n8u2mtgj9oibddcsnek3rgy4azkxw1bzkacwk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    @stack('page-scripts')
</body>

</html>
