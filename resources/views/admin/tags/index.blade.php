@extends('layouts.app-dashboard')

@section('title', 'Gestion des tags')
@section('page-title', 'Gestion des tags')

@section('content')
    <div class="dashboard-section">
        <!-- En-tête avec bouton créer -->
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Gestion des tags</h1>
                <p class="dashboard-subtitle">Gérez les tags par famille pour catégoriser les tutoriels</p>
            </div>
            <div class="dashboard-actions">
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer un tag
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

        <!-- Liste des tags par famille -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            @forelse($tags as $family => $familyTags)
                <div class="card" style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #e2e8f0;">
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #0f172a; margin: 0;">
                            {{ $family }}
                        </h2>
                        <span style="background: #e2e8f0; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem;">
                            {{ $familyTags->count() }} tag(s)
                        </span>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        @foreach($familyTags as $tag)
                            <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                                <span style="font-weight: 500; color: #334155;">{{ $tag->name }}</span>
                                <span style="font-size: 0.75rem; color: #94a3b8;">({{ $tag->tutorials()->count() }})</span>
                                
                                <div style="display: flex; gap: 0.25rem; margin-left: 0.5rem;">
                                    <a href="{{ route('admin.tags.edit', $tag) }}" style="color: #3b82f6; padding: 0.25rem;" title="Modifier">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" style="display: inline;"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #ef4444; padding: 0.25rem; background: none; border: none; cursor: pointer;" title="Supprimer">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">🏷️</div>
                    <h3 class="empty-title">Aucun tag</h3>
                    <p class="empty-description">
                        Commencez par créer votre premier tag.
                    </p>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Créer un tag
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection