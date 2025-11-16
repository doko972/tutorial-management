@extends('layouts.app-auth')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">HT</div>
        <h1>Réinitialiser le mot de passe</h1>
        <p>Entrez votre nouveau mot de passe ci-dessous</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}" 
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
            <label for="password">Nouveau mot de passe</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password"
                placeholder="••••••••"
            >
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="••••••••"
            >
            @error('password_confirmation')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            Réinitialiser le mot de passe
        </button>
    </form>

    <div class="auth-footer">
        <p>
            Retour à la 
            <a href="{{ route('login') }}">page de connexion</a>
        </p>
    </div>
</div>
@endsection