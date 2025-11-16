<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        .lottie-animation {
            width: 400px;
            height: 400px;
            margin: 0 auto 2rem;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin: 0 0 1rem 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 0 0 2rem 0;
            line-height: 1.6;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-home svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Particules en arrière-plan */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-100px) translateX(50px);
            }
        }
    </style>
</head>
<body>
    <!-- Particules décoratives -->
    <div class="particles">
        <div class="particle" style="width: 60px; height: 60px; left: 10%; top: 20%; animation-delay: 0s;"></div>
        <div class="particle" style="width: 40px; height: 40px; left: 80%; top: 30%; animation-delay: 2s;"></div>
        <div class="particle" style="width: 80px; height: 80px; left: 20%; top: 70%; animation-delay: 4s;"></div>
        <div class="particle" style="width: 50px; height: 50px; left: 70%; top: 60%; animation-delay: 6s;"></div>
        <div class="particle" style="width: 30px; height: 30px; left: 50%; top: 10%; animation-delay: 8s;"></div>
    </div>

    <div class="error-container">
        <!-- Animation Lottie -->
        <div id="lottie-404" class="lottie-animation"></div>

        <h1>Oups ! Page introuvable</h1>
        <p>
            La page que vous recherchez semble avoir disparu dans le cyberespace. 
            Peut-être qu'elle n'a jamais existé, ou peut-être qu'elle a été déplacée.
        </p>

        <a href="{{ route('home') }}" class="btn-home">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Retour à l'accueil
        </a>
    </div>

    <!-- Lottie Player -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        // Charger l'animation Lottie
        const animation = lottie.loadAnimation({
            container: document.getElementById('lottie-404'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '/animations/404.json'
        });
    </script>
</body>
</html>