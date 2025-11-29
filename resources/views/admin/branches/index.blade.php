@extends('layouts.app-dashboard')

@section('title', 'Gestion des branches')
@section('page-title', 'Gestion des branches')

@section('content')
    <div class="dashboard-section">
        <!-- En-tête avec bouton créer -->
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Gestion des branches</h1>
                <p class="dashboard-subtitle">Gérez les différentes branches de l'entreprise</p>
            </div>
            <div class="dashboard-actions">
                <a href="{{ route('admin.branches.create') }}" class="btn btn-primary btn-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer une branche
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

        <!-- Liste des branches -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            @foreach($branches as $branch)
                <!-- Branche principale -->
                <div>
                    <div class="card" style="border-top: 4px solid {{ $branch->color }};">
                        <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-bottom: 0.5rem;">
                                    {{ $branch->name }}
                                </h3>
                                @if($branch->description)
                                    <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 1rem;">
                                        {{ $branch->description }}
                                    </p>
                                @endif
                            </div>
                            <div style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: {{ $branch->color }}20; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                @if($branch->icon)
                                    <i data-lucide="{{ $branch->icon }}" style="width: 1.5rem; height: 1.5rem; color: {{ $branch->color }};"></i>
                                @else
                                    <svg style="width: 1.5rem; height: 1.5rem; color: {{ $branch->color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Statistiques -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; margin-bottom: 1rem;">
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: {{ $branch->color }};">
                                    {{ $branch->users_count }}
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Utilisateurs
                                </div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: {{ $branch->color }};">
                                    {{ $branch->tutorials_count }}
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Tutoriels
                                </div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: {{ $branch->color }};">
                                    {{ $branch->children->count() }}
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Sous-branches
                                </div>
                            </div>
                        </div>

                        <!-- Métadonnées -->
                        <div style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                <strong>Slug:</strong> {{ $branch->slug }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <strong>Couleur:</strong>
                                <span style="display: inline-block; width: 1rem; height: 1rem; background: {{ $branch->color }}; border-radius: 0.25rem; border: 1px solid #e2e8f0;"></span>
                                {{ $branch->color }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 0.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                            <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-sm btn-primary" style="flex: 1;">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier
                            </a>
                            <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" style="flex: 1;"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette branche ? Cette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="width: 100%;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Sous-branches -->
                    @if($branch->children->count() > 0)
                        <div style="margin-left: 2rem; margin-top: 1rem; padding-left: 1rem; border-left: 3px solid {{ $branch->color }};">
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                                @foreach($branch->children as $child)
                                    <div class="card" style="border-top: 3px solid {{ $child->color ?? $branch->color }}; padding: 1rem;">
                                        <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 0.75rem;">
                                            <div style="flex: 1;">
                                                <h4 style="font-size: 1rem; font-weight: 600; color: #0f172a; margin-bottom: 0.25rem;">
                                                    {{ $child->name }}
                                                </h4>
                                                @if($child->description)
                                                    <p style="font-size: 0.75rem; color: #64748b;">
                                                        {{ Str::limit($child->description, 60) }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.375rem; background: {{ $child->color ?? $branch->color }}20; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                @if($child->icon)
                                                    <i data-lucide="{{ $child->icon }}" style="width: 1.25rem; height: 1.25rem; color: {{ $child->color ?? $branch->color }};"></i>
                                                @else
                                                    <svg style="width: 1.25rem; height: 1.25rem; color: {{ $child->color ?? $branch->color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Stats sous-branche -->
                                        <div style="display: flex; gap: 1rem; padding: 0.5rem; background: #f8fafc; border-radius: 0.375rem; margin-bottom: 0.75rem; font-size: 0.75rem;">
                                            <div style="text-align: center; flex: 1;">
                                                <div style="font-weight: 700; color: {{ $child->color ?? $branch->color }};">{{ $child->users_count }}</div>
                                                <div style="color: #64748b;">Utilisateurs</div>
                                            </div>
                                            <div style="text-align: center; flex: 1;">
                                                <div style="font-weight: 700; color: {{ $child->color ?? $branch->color }};">{{ $child->tutorials_count }}</div>
                                                <div style="color: #64748b;">Tutoriels</div>
                                            </div>
                                        </div>

                                        <!-- Actions sous-branche -->
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('admin.branches.edit', $child) }}" class="btn btn-sm btn-primary" style="flex: 1; padding: 0.375rem;">
                                                Modifier
                                            </a>
                                            <form action="{{ route('admin.branches.destroy', $child) }}" method="POST" style="flex: 1;"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette sous-branche ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" style="width: 100%; padding: 0.375rem;">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($branches->count() === 0)
            <div class="empty-state">
                <div class="empty-icon">🏢</div>
                <h3 class="empty-title">Aucune branche</h3>
                <p class="empty-description">
                    Commencez par créer votre première branche.
                </p>
                <a href="{{ route('admin.branches.create') }}" class="btn btn-primary btn-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer une branche
                </a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();
        </script>
    @endpush
@endsection