@extends('layouts.app-dashboard')

@section('title', 'Tous les tutoriels')
@section('page-title', 'Tous les tutoriels')

@section('content')
    <div class="dashboard-section">
        <!-- Filtres -->
        <!-- Filtres avancés -->
        <div class="filters-bar">
            <form method="GET" action="{{ route('tutorials.index') }}" style="width: 100%;">
                <!-- Ligne 1 : Recherche principale -->
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; margin-bottom: 1rem;">
                    <input type="text" name="search" class="form-control"
                        placeholder="Rechercher un tutoriel par titre, description ou contenu..."
                        value="{{ request('search') }}" style="font-size: 1rem; padding: 0.75rem 1rem;">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 0.75rem 2rem;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Rechercher
                    </button>
                </div>

                <!-- Ligne 2 : Filtres avancés -->
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                    <!-- Filtre par branche -->
                    <select name="branch" class="form-control">
                        <option value="">📁 Toutes les branches</option>
                        @foreach($branches as $branch)
                            @if($branch->parent_id === null)
                                <!-- Branche principale -->
                                <optgroup label="{{ $branch->name }}">
                                    <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        📂 {{ $branch->name }} ({{ $branch->tutorials_count }})
                                    </option>

                                    <!-- Sous-branches -->
                                    @foreach($branch->children as $child)
                                        <option value="{{ $child->id }}" {{ request('branch') == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;└─ {{ $child->name }} ({{ $child->tutorials_count }})
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>

                    <!-- Filtre par type -->
                    <select name="type" class="form-control">
                        <option value="">📄 Tous les types</option>
                        <option value="text" {{ request('type') == 'text' ? 'selected' : '' }}>Texte</option>
                        <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Document</option>
                        <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Vidéo</option>
                        <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Lien</option>
                    </select>

                    <!-- Filtre par tag -->
                    <select name="tag" class="form-control">
                        <option value="">🏷️ Tous les tags</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }} ({{ $tag->tutorials_count }})
                            </option>
                        @endforeach
                    </select>

                    <!-- Filtre par date -->
                    <select name="date" class="form-control">
                        <option value="">📅 Toutes les dates</option>
                        <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                        <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Ce mois</option>
                        <option value="year" {{ request('date') == 'year' ? 'selected' : '' }}>Cette année</option>
                    </select>

                    <!-- Tri -->
                    <select name="sort" class="form-control">
                        <option value="">🔄 Tri par défaut</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Titre (A-Z)</option>
                    </select>
                </div>

                <!-- Ligne 3 : Actions -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    @if($hasFilters)
                        <a href="{{ route('tutorials.index') }}" class="btn btn-secondary">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                            Réinitialiser les filtres
                        </a>
                    @else
                        <div></div>
                    @endif

                    <div style="color: #64748b; font-size: 0.875rem;">
                        <strong>{{ $totalResults }}</strong> tutoriel(s) trouvé(s)
                    </div>
                </div>
            </form>
        </div>

        <!-- Résultats -->
        @if($tutorials->count() > 0)
            <div class="tutorials-grid">
                @foreach($tutorials as $tutorial)
                    <div class="card card-tutorial card-branch {{ $tutorial->branch->slug }}">
                        <!-- Badge type -->
                        <span class="tutorial-badge">{{ strtoupper($tutorial->file_type) }}</span>

                        <!-- Miniature -->
                        @if($tutorial->thumbnail)
                            <img src="{{ Storage::url($tutorial->thumbnail) }}" alt="{{ $tutorial->title }}" class="tutorial-thumbnail">
                        @else
                            <div class="tutorial-thumbnail"
                                style="background: linear-gradient(135deg, {{ $tutorial->branch->color }} 0%, {{ $tutorial->branch->color }}dd 100%); display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 4rem; height: 4rem; color: white;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif

                        <!-- Titre -->
                        <h3 class="tutorial-title">{{ $tutorial->title }}</h3>

                        <!-- Description -->
                        @if($tutorial->description)
                            <p class="tutorial-description">{{ $tutorial->description }}</p>
                        @endif

                        <!-- Meta -->
                        <div class="tutorial-meta">
                            <div class="meta-item">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $tutorial->author->name }}
                            </div>
                            <div class="meta-item">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                {{ $tutorial->views_count }}
                            </div>
                        </div>

                        <!-- Lien -->
                        <a href="{{ route('tutorials.show', $tutorial) }}" style="position: absolute; inset: 0;"></a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                {{ $tutorials->links() }}
            </div>
        @else
            <div class="card" style="padding: 4rem 2rem; text-align: center;">
                <div id="lottie-no-results" style="width: 350px; height: 350px; margin: 0 auto;"></div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: #0f172a; margin: 1.5rem 0 0.5rem;">
                    Aucun tutoriel trouvé
                </h3>
                <p style="color: #64748b; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                    @if(request()->hasAny(['search', 'branch', 'type', 'tag', 'date', 'sort']))
                        Aucun tutoriel ne correspond à vos critères de recherche. Essayez avec d'autres filtres !
                    @else
                        Il n'y a pas encore de tutoriel disponible. Revenez plus tard !
                    @endif
                </p>
                @if(request()->hasAny(['search', 'branch', 'type', 'tag', 'date', 'sort']))
                    <a href="{{ route('tutorials.index') }}" class="btn btn-primary">Voir tous les tutoriels</a>
                @endif
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
            <script>
                lottie.loadAnimation({
                    container: document.getElementById('lottie-no-results'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: '/animations/no-results.json'
                });
            </script>
        @endif
    </div>
@endsection