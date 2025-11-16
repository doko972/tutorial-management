@extends('layouts.app-auth')

@section('title', 'Confirmation du mot de passe')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">HT</div>
        <h1>Zone sécurisée</h1>
        <p>Veuillez confirmer votre mot de passe avant de continuer.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

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
                autofocus
            >
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            Confirmer
        </button>
    </form>

    <div class="auth-footer">
        <p>
            <a href="{{ route('dashboard') }}">Retour au tableau de bord</a>
        </p>
    </div>
</div>
@endsection