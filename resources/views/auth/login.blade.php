@extends('layouts.app-auth')

@section('title', 'Connexion')

@section('content')
    <div class="auth-card">
        <div class="auth-logo">
            <!-- Logo -->
            <div class="landing-logo-c">
                <div id="logo-header" class="logo-animation-c"></div>
                <h1>HR Télécoms</h1>
            </div>
            {{-- <p>Connectez-vous à votre espace tutoriels</p> --}}
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success"
                style="margin-bottom: 1rem; padding: 0.75rem; background: #d1fae5; color: #065f46; border-radius: 0.5rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" placeholder="nom@exemple.com">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <div style="position: relative;">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        style="padding-right: 3rem;">
                    <button type="button" onclick="togglePassword()"
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.5rem; color: #64748b;"
                        tabindex="-1">
                        <svg id="eye-open" style="width: 1.25rem; height: 1.25rem; display: block;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        <svg id="eye-closed" style="width: 1.25rem; height: 1.25rem; display: none;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                            </path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-options">
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Se souvenir de moi</label>
                </div>

                {{-- @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Mot de passe oublié ?
                    </a>
                @endif --}}
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                Se connecter
            </button>
        </form>

        {{-- <div class="auth-footer">
            <p>
                Pas encore de compte ?
                <a href="{{ route('register') }}">Créer un compte</a>
            </p>
        </div> --}}
    </div>
    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }
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

        // Rejouer l'animation au survol
        document.getElementById('logo-footer').addEventListener('mouseenter', function() {
            logoFooter.goToAndPlay(0, true); // Rejoue depuis le début
        });
    </script>
@endsection
