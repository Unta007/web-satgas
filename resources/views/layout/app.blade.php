<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Page Title')</title>
    @vite('resources/sass/app.scss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/welcome.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/educational.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/article.css') }}">
</head>

<body>
    @include('layout.navbar')

    @yield('content')

    @include('layout.footer')

    @vite('resources/js/app.js')
    @vite('resources/js/report.js')
</body>

</html>
