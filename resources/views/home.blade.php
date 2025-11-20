<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tutorial Management') }} - Accueil</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="landing-page">
        <!-- Navbar -->
        <nav class="landing-navbar">
            <div class="container">
                <div class="landing-logo">
                    <div id="logo-header" class="logo-animation"></div>
                    <span>HR Télécoms</span>
                </div>
                <div class="landing-nav-links">
                    @auth
                        <a href="{{ route('dashboard') }}">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}">Connexion</a>
                        <a href="{{ route('register') }}">Inscription</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <h1 class="hero-title">Plateforme de Tutoriels<br>HR Télécoms</h1>
                <p class="hero-subtitle">
                    Accédez à tous les tutoriels de l'entreprise en un seul endroit.
                    Apprenez, partagez et développez vos compétences.
                </p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-primary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 1.5rem; height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Accéder au tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hero-btn hero-btn-primary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 1.5rem; height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Se connecter
                        </a>
                        {{-- <a href="{{ route('register') }}" class="hero-btn hero-btn-outline">Créer un compte</a> --}}
                    @endauth
                </div>
            </div>
        </section>
    </div>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $totalTutorials }}</div>
                <div class="stat-label">Tutoriels disponibles</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $totalBranches }}</div>
                <div class="stat-label">Branches</div>
            </div>
        </div>
    </section>
    <section class="branches-section">
        <div class="branches-container">
            <h2 class="section-title">Les Branches</h2>
            <p class="section-subtitle">Explorez les tutoriels par branches</p>

            <div class="branches-grid">
                @foreach ($branches as $branch)
                    <div class="branch-card" style="border-top-color: {{ $branch->color }}">
                        <div class="branch-icon"
                            style="background: {{ $branch->color }}20; color: {{ $branch->color }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="branch-name">{{ $branch->name }}</h3>
                        <p class="branch-count">{{ $branch->tutorials_count }} tutoriel(s)</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <!-- Logo et description -->
            <div class="footer-column">
                <div class="footer-logo">
                    <div id="logo-footer" class="logo-animation"></div>
                    <span>HR Télécoms</span>
                </div>
                <p class="footer-description">
                    Plateforme de formation et de partage de connaissances.
                    Accédez à des centaines de tutoriels pour développer vos compétences chez HR Télécoms.
                </p>
            </div>

            <!-- Branches -->
            <div class="footer-column">
                <h4 class="footer-title">Les Branches</h4>
                <ul class="footer-links">
                    @foreach ($branches as $branch)
                        <li>
                            <a href="{{ route('tutorials.index', ['branch' => $branch->id]) }}">
                                <span style="color: {{ $branch->color }};">●</span> {{ $branch->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact & Infos -->
            <div class="footer-column">
                <h4 class="footer-title">Contact</h4>
                <ul class="footer-contact">
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <a href="mailto:contact@hrttelecoms.fr">contact@hrttelecoms.fr</a>
                    </li>
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <a href="tel:+33123456789">+33 2 31 43 50 11</a>
                    </li>
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Caen, Normandie, France</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; {{ date('Y') }} HR Télécoms. Tous droits réservés.</p>
                <div class="footer-bottom-links">
                    <a href="#">Mentions légales</a>
                    <span>•</span>
                    <a href="#">Politique de confidentialité</a>
                    <span>•</span>
                    <a href="#">CGU</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        // Animation logo header (coloré)
        const logoHeader = lottie.loadAnimation({
            container: document.getElementById('logo-header'),
            renderer: 'svg',
            loop: false, // Pas de boucle
            autoplay: true, // Joue une fois au chargement
            path: '/animations/logo.json'
        });

        // Rejouer l'animation au survol
        document.getElementById('logo-header').addEventListener('mouseenter', function() {
            logoHeader.goToAndPlay(0, true); // Rejoue depuis le début
        });

        // Animation logo footer (blanc)
        const logoFooter = lottie.loadAnimation({
            container: document.getElementById('logo-footer'),
            renderer: 'svg',
            loop: false, // Pas de boucle
            autoplay: true, // Joue une fois au chargement
            path: '/animations/logo-white.json'
        });

        // Rejouer l'animation au survol
        const logoFooterElement = document.getElementById('logo-footer');
        if (logoFooterElement) {
            logoFooterElement.addEventListener('mouseenter', function() {
                logoFooter.goToAndPlay(0, true); // Rejoue depuis le début
            });
        }
    </script>
</body>

</html>
