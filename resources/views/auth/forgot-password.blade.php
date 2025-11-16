@extends('layouts.app-auth')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">HT</div>
        <h1>Mot de passe oublié ?</h1>
        <p>Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" style="margin-bottom: 1rem; padding: 0.75rem; background: #d1fae5; color: #065f46; border-radius: 0.5rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
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
                placeholder="nom@exemple.com"
            >
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <div class="auth-footer">
        <p>
            Vous vous souvenez de votre mot de passe ? 
            <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </div>
</div>
@endsection