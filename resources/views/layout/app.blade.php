{{-- resources/views/layout/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Satgas PPKS ITTS')</title>

    {{-- Mengimpor Bootstrap & CSS utama kita dari Vite --}}
    @vite(['resources/sass/app.scss', 'resources/css/welcome.css', 'resources/css/educational.css', 'resources/css/report-form.css', 'resources/css/article.css', 'resources/js/app.js', 'resources/js/load_more.js', 'resources/js/report.js'])

    {{-- Link Bootstrap Icons dari CDN (sudah benar) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    @stack('styles')
</head>

<body>
    @include('layout.navbar')

    <main>
        @yield('content')
    </main>

    @include('layout.footer')

    @stack('scripts')
</body>

</html>
