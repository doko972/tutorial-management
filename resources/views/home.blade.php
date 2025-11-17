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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .landing-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #3b82f6 0%, #64748b 100%);
            position: relative;
            overflow: hidden;
        }

        .landing-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .landing-navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
        }

        .landing-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .landing-logo .logo-icon {
            width: 3rem;
            height: 3rem;
            background: white;
            color: #3b82f6;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .landing-nav-links {
            display: flex;
            gap: 2rem;
        }

        .landing-nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .landing-nav-links a:hover {
            opacity: 0.8;
        }

        .hero-section {
            padding-top: 8rem;
            padding-bottom: 6rem;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 1rem 2.5rem;
            border-radius: 0.75rem;
            font-size: 1.125rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hero-btn-primary {
            background: white;
            color: #3b82f6;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .hero-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .hero-btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .hero-btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .stats-section {
            background: white;
            padding: 4rem 2rem;
            margin: 0 2rem;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: translateY(-3rem);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.125rem;
            color: #64748b;
            font-weight: 500;
        }

        .features-section {
            padding: 6rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 4rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #3b82f6 0%, #64748b 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon svg {
            width: 2rem;
            height: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #64748b;
            line-height: 1.7;
        }

        .branches-section {
            padding: 6rem 2rem;
            background: #f8fafc;
        }

        .branches-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .branches-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .branch-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border-top: 4px solid;
        }

        .branch-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .branch-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .branch-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .branch-count {
            color: #64748b;
        }

        .cta-section {
            padding: 6rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, #3b82f6 0%, #64748b 100%);
            color: white;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .footer {
            background: #0f172a;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.125rem;
            }
            .landing-nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="landing-page">
        <!-- Navbar -->
        <nav class="landing-navbar">
            <div class="container">
                <div class="landing-logo">
                    <div class="logo-icon">HT</div>
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
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.5rem; height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Accéder au tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hero-btn hero-btn-primary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.5rem; height: 1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="hero-btn hero-btn-outline">Créer un compte</a>
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
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Gratuit</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <h2 class="section-title">Pourquoi utiliser notre plateforme ?</h2>
        <p class="section-subtitle">Tout ce dont vous avez besoin pour apprendre et progresser</p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Bibliothèque complète</h3>
                <p class="feature-description">Accédez à une vaste collection de tutoriels couvrant tous les domaines de l'entreprise.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Organisé par branches</h3>
                <p class="feature-description">Trouvez facilement les tutoriels de votre service : Administratif, Comptabilité, Technique, Commercial.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Formats multiples</h3>
                <p class="feature-description">Documents Word, PDF, vidéos... Choisissez le format qui vous convient le mieux.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Collaboration</h3>
                <p class="feature-description">Créez et partagez vos propres tutoriels pour aider vos collègues.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Recherche rapide</h3>
                <p class="feature-description">Trouvez instantanément le tutoriel dont vous avez besoin grâce à notre moteur de recherche.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Sécurisé</h3>
                <p class="feature-description">Vos données et contenus sont protégés avec un système d'authentification sécurisé.</p>
            </div>
        </div>
    </section>

    <!-- Branches Section -->
    <section class="branches-section">
        <div class="branches-container">
            <h2 class="section-title">Nos Branches</h2>
            <p class="section-subtitle">Explorez les tutoriels par département</p>
            
            <div class="branches-grid">
                @foreach($branches as $branch)
                <div class="branch-card" style="border-top-color: {{ $branch->color }}">
                    <div class="branch-icon" style="background: {{ $branch->color }}20; color: {{ $branch->color }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="branch-name">{{ $branch->name }}</h3>
                    <p class="branch-count">{{ $branch->tutorials_count }} tutoriel(s)</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Prêt à commencer ?</h2>
            <p class="cta-subtitle">Rejoignez la plateforme dès maintenant et accédez à tous nos tutoriels</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-primary">Accéder au tableau de bord</a>
                @else
                    <a href="{{ route('register') }}" class="hero-btn hero-btn-primary">Créer un compte gratuit</a>
                    <a href="{{ route('login') }}" class="hero-btn hero-btn-outline">Se connecter</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} HR Télécoms. Tous droits réservés.</p>
    </footer>
</body>
</html>