@extends('layouts.app-dashboard')

@section('title', 'Créer un utilisateur')
@section('page-title', 'Créer un utilisateur')

@section('content')
<div class="dashboard-section">
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem;">
        <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
            <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
            <li>/</li>
            <li><a href="{{ route('admin.users.index') }}" style="color: #3b82f6; text-decoration: none;">Utilisateurs</a></li>
            <li>/</li>
            <li>Créer</li>
        </ol>
    </nav>

    <div style="max-width: 700px; margin: 0 auto;">
        <div class="card" style="padding: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">
                Créer un nouvel utilisateur
            </h1>
            <p style="color: #64748b; margin-bottom: 2rem;">
                Ajoutez un nouvel utilisateur à la plateforme
            </p>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <!-- Nom -->
                <div class="form-group">
                    <label for="name">Nom complet *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') has-error @enderror" 
                        value="{{ old('name') }}" 
                        required
                        placeholder="Jean Dupont"
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control @error('email') has-error @enderror" 
                        value="{{ old('email') }}" 
                        required
                        placeholder="jean.dupont@hrttelecoms.fr"
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Branche -->
                <div class="form-group">
                    <label for="branch_id">Branche</label>
                    <select id="branch_id" name="branch_id" class="form-control @error('branch_id') has-error @enderror">
                        <option value="">Aucune branche</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="form-text">Les administrateurs n'ont généralement pas de branche assignée</span>
                    @error('branch_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Rôle -->
                <div class="form-group">
                    <label for="role">Rôle *</label>
                    <select id="role" name="role" class="form-control @error('role') has-error @enderror" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    <span class="form-text">
                        <strong>Utilisateur :</strong> Peut créer des tutoriels dans sa branche<br>
                        <strong>Manager :</strong> Peut gérer les tutoriels de sa branche<br>
                        <strong>Administrateur :</strong> Accès complet à toute la plateforme
                    </span>
                    @error('role')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') has-error @enderror" 
                        required
                        placeholder="••••••••"
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe *</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        required
                        placeholder="••••••••"
                    >
                </div>

                <!-- Boutons -->
                <div style="display: flex; gap: 1rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-primary btn-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Créer l'utilisateur
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection