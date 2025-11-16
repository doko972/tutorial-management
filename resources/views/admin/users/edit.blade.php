@extends('layouts.app-dashboard')

@section('title', 'Modifier un utilisateur')
@section('page-title', 'Modifier un utilisateur')

@section('content')
<div class="dashboard-section">
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem;">
        <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
            <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
            <li>/</li>
            <li><a href="{{ route('admin.users.index') }}" style="color: #3b82f6; text-decoration: none;">Utilisateurs</a></li>
            <li>/</li>
            <li>Modifier</li>
        </ol>
    </nav>

    <div style="max-width: 700px; margin: 0 auto;">
        <div class="card" style="padding: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">
                Modifier l'utilisateur
            </h1>
            <p style="color: #64748b; margin-bottom: 2rem;">
                Modifiez les informations de <strong>{{ $user->name }}</strong>
            </p>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div class="form-group">
                    <label for="name">Nom complet *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') has-error @enderror" 
                        value="{{ old('name', $user->name) }}" 
                        required
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
                        value="{{ old('email', $user->email) }}" 
                        required
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
                            <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Rôle -->
                <div class="form-group">
                    <label for="role">Rôle *</label>
                    <select id="role" name="role" class="form-control @error('role') has-error @enderror" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div style="padding: 1.5rem; background: #fef3c7; border-radius: 0.5rem; margin-bottom: 1.5rem; border-left: 4px solid #f59e0b;">
                    <p style="font-size: 0.875rem; color: #78350f; margin: 0;">
                        <strong>Note :</strong> Laissez les champs de mot de passe vides si vous ne souhaitez pas le modifier.
                    </p>
                </div>

                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') has-error @enderror" 
                        placeholder="••••••••"
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        placeholder="••••••••"
                    >
                </div>

                <!-- Boutons -->
                <div style="display: flex; gap: 1rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-primary btn-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enregistrer les modifications
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