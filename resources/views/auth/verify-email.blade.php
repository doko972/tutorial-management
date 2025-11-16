@extends('layouts.app-auth')

@section('title', 'Vérification email')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo-icon">HT</div>
        <h1>Vérification de l'email</h1>
        <p>Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ?</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" style="margin-bottom: 1rem; padding: 0.75rem; background: #d1fae5; color: #065f46; border-radius: 0.5rem;">
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <div class="auth-form">
        <p style="text-align: center; margin-bottom: 1.5rem; color: #64748b;">
            Si vous n'avez pas reçu l'email, nous serons ravis de vous en envoyer un nouveau.
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="submit-btn">
                Renvoyer l'email de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
            @csrf
            <button type="submit" class="submit-btn" style="background: transparent; color: #3b82f6; border: 2px solid #3b82f6;">
                Se déconnecter
            </button>
        </form>
    </div>
</div>
@endsection