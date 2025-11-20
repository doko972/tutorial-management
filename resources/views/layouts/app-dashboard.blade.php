<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Tutorial Management') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v={{ time() }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Navbar -->
        @include('layouts.partials.navbar')

        <!-- Main Content -->
        <main class="dashboard-content" id="dashboard-content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        // Animation logo header (coloré)
        const logoHeader = lottie.loadAnimation({
            container: document.getElementById('logo-header'),
            renderer: 'svg',
            loop: false, // Pas de boucle
            autoplay: true, // Joue une fois au chargement
            path: '/animations/logo-white.json'
        });

        // Rejouer l'animation au survol
        document.getElementById('logo-header').addEventListener('mouseenter', function() {
            logoHeader.goToAndPlay(0, true); // Rejoue depuis le début
        });

        // Rejouer l'animation au survol
        document.getElementById('logo-footer').addEventListener('mouseenter', function() {
            logoFooter.goToAndPlay(0, true); // Rejoue depuis le début
        });
    </script>
</body>

</html>
