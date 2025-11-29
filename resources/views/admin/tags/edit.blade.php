@extends('layouts.app-dashboard')

@section('title', 'Modifier un tag')
@section('page-title', 'Modifier un tag')

@section('content')
    <div class="dashboard-section">
        <!-- Breadcrumb -->
        <nav style="margin-bottom: 2rem;">
            <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
                <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
                <li>/</li>
                <li><a href="{{ route('admin.tags.index') }}" style="color: #3b82f6; text-decoration: none;">Tags</a></li>
                <li>/</li>
                <li>Modifier</li>
            </ol>
        </nav>

        <div style="max-width: 700px; margin: 0 auto;">
            <div class="card" style="padding: 2rem;">
                <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">
                    Modifier le tag
                </h1>
                <p style="color: #64748b; margin-bottom: 2rem;">
                    Modifiez les informations du tag <strong>{{ $tag->name }}</strong>
                </p>

                <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom -->
                    <div class="form-group">
                        <label for="name">Nom du tag *</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') has-error @enderror" value="{{ old('name', $tag->name) }}" required
                            placeholder="Ex: Débutant, Excel, Windows...">
                        <span class="form-text">Le slug sera généré automatiquement à partir du nom</span>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Famille -->
                    <div class="form-group">
                        <label for="family">Famille *</label>
                        <input type="text" id="family" name="family" list="family-list"
                            class="form-control @error('family') has-error @enderror" value="{{ old('family', $tag->family) }}" required
                            placeholder="Ex: Difficulté, Office, Système...">
                        <datalist id="family-list">
                            @foreach($families as $family)
                                <option value="{{ $family }}">
                            @endforeach
                        </datalist>
                        <span class="form-text">Choisissez une famille existante ou créez-en une nouvelle</span>
                        @error('family')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Info utilisation -->
                    @if($tag->tutorials()->count() > 0)
                        <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fef3c7; color: #92400e; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
                            Ce tag est utilisé par {{ $tag->tutorials()->count() }} tutoriel(s).
                        </div>
                    @endif

                    <!-- Boutons -->
                    <div style="display: flex; gap: 1rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                        <button type="submit" class="btn btn-primary btn-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 1.25rem; height: 1.25rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Enregistrer les modifications
                        </button>
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection