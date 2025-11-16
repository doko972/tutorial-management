@extends('layouts.app-auth')

@section('title', 'Connexion')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">HT</div>
        <h1>HR Télécoms</h1>
        <p>Connectez-vous à votre espace tutoriels</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" style="margin-bottom: 1rem; padding: 0.75rem; background: #d1fae5; color: #065f46; border-radius: 0.5rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="nom@exemple.com"
            >
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                placeholder="••••••••"
            >
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="form-options">
            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            Se connecter
        </button>
    </form>

    <div class="auth-footer">
        <p>
            Pas encore de compte ? 
            <a href="{{ route('register') }}">Créer un compte</a>
        </p>
    </div>
</div>
@endsection