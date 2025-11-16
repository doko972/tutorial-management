@extends('layouts.app-dashboard')

@section('title', 'Gestion des utilisateurs')
@section('page-title', 'Gestion des utilisateurs')

@section('content')
<div class="dashboard-section">
    <!-- En-tête avec bouton créer -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Gestion des utilisateurs</h1>
            <p class="dashboard-subtitle">Gérez les utilisateurs de la plateforme</p>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Créer un utilisateur
            </a>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div style="margin-bottom: 1.5rem; padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 0.5rem; border-left: 4px solid #10b981;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 0.5rem; border-left: 4px solid #ef4444;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtres -->
    <div class="filters-bar">
        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-3" style="width: 100%;">
            <!-- Recherche -->
            <div class="filter-item">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Rechercher un utilisateur..."
                    value="{{ request('search') }}"
                >
            </div>

            <!-- Filtre par branche -->
            <div class="filter-item">
                <select name="branch" class="form-control">
                    <option value="">Toutes les branches</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par rôle -->
            <div class="filter-item">
                <select name="role" class="form-control">
                    <option value="">Tous les rôles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
            </div>

            <!-- Boutons -->
            <button type="submit" class="btn btn-primary">Filtrer</button>
            
            @if(request()->hasAny(['search', 'branch', 'role']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Table des utilisateurs -->
    @if($users->count() > 0)
        <div class="card" style="overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Utilisateur</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Email</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Branche</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Rôle</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Tutoriels</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: #475569; font-size: 0.875rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="border-top: 1px solid #e2e8f0;">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div style="font-weight: 600; color: #0f172a;">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td style="padding: 1rem; color: #64748b;">{{ $user->email }}</td>
                            <td style="padding: 1rem;">
                                @if($user->branch)
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: {{ $user->branch->color }}20; color: {{ $user->branch->color }}; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                        {{ $user->branch->name }}
                                    </span>
                                @else
                                    <span style="color: #94a3b8; font-size: 0.875rem;">Aucune</span>
                                @endif
                            </td>
                            <td style="padding: 1rem;">
                                @if($user->role === 'admin')
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #fef3c7; color: #92400e; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                        Administrateur
                                    </span>
                                @elseif($user->role === 'manager')
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #dbeafe; color: #1e40af; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                        Manager
                                    </span>
                                @else
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #f1f5f9; color: #475569; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                        Utilisateur
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem; color: #64748b;">
                                {{ $user->tutorials_count ?? 0 }}
                            </td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm" style="background: transparent; color: #f59e0b; border: 1px solid #f59e0b;" title="Modifier">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background: transparent; color: #ef4444; border: 1px solid #ef4444;" title="Supprimer">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <h3 class="empty-title">Aucun utilisateur trouvé</h3>
            <p class="empty-description">
                @if(request()->hasAny(['search', 'branch', 'role']))
                    Aucun utilisateur ne correspond à vos critères de recherche.
                @else
                    Commencez par créer votre premier utilisateur.
                @endif
            </p>
            @if(request()->hasAny(['search', 'branch', 'role']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Voir tous les utilisateurs</a>
            @else
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer un utilisateur
                </a>
            @endif
        </div>
    @endif
</div>
@endsection