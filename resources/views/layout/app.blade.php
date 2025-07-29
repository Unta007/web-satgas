<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Satgas PPKPT Kampus Surabaya')</title>

    @vite(['resources/sass/app.scss', 'resources/css/welcome.css', 'resources/css/hero.css', 'resources/css/contact-page.css', 'resources/css/educational.css', 'resources/css/report-form.css', 'resources/css/report-detail.css', 'resources/css/article.css', 'resources/css/user-profile.css', 'resources/css/about-us.css', 'resources/js/app.js', 'resources/js/user-profile.js', 'resources/js/load_more.js', 'resources/js/report.js', 'resources/js/scroll-animate.js'])

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
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/68526cdc4be5e7190b533af7/1iu0vifpu';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
</body>

</html>
