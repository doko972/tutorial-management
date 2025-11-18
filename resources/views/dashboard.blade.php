@extends('layouts.app-dashboard')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
    <div class="home-page">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>Bienvenue, {{ auth()->user()->name }} !</h1>
                <p>Gérez et consultez tous les tutoriels de l'entreprise en un seul endroit.</p>
                <div class="welcome-actions">
                    @if(auth()->user()->branch_id)
                        <a href="{{ route('my-tutorials.create') }}" class="btn btn-primary btn-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Créer un tutoriel
                        </a>
                    @endif
                    <a href="{{ route('tutorials.index') }}" class="btn btn-outline">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Parcourir les tutoriels
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Tutoriels</div>
                    <div class="stat-value">{{ \App\Models\Tutorial::count() }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Branches</div>
                    <div class="stat-value">{{ \App\Models\Branch::count() }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Vues totales</div>
                    <div class="stat-value">{{ \App\Models\TutorialView::count() }}</div>
                </div>
            </div>

            @if(auth()->user()->branch_id)
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Mes Tutoriels</div>
                        <div class="stat-value">{{ auth()->user()->tutorials()->count() }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Branches Overview -->
        <div class="branches-overview">
            <div class="section-header">
                <h2>Explorer par branche</h2>
            </div>
            <div class="branches-grid">
                @php
                    $branches = \App\Models\Branch::whereNull('parent_id')->withCount('tutorials')->with([
                        'children' => function ($query) {
                            $query->withCount('tutorials');
                        }
                    ])->get();
                @endphp
                @foreach($branches as $branch)
                    <div class="branch-card" style="border-top-color: {{ $branch->color }};">
                        <div class="branch-icon" style="background: {{ $branch->color }}20; color: {{ $branch->color }};">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="branch-name">{{ $branch->name }}</div>
                        <div class="branch-count">{{ $branch->tutorials_count }} tutoriel(s)</div>

                        @if($branch->children->count() > 0)
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                                <div style="font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">
                                    Sous-branches :</div>
                                @foreach($branch->children as $child)
                                    <div
                                        style="display: flex; justify-content: space-between; padding: 0.25rem 0; font-size: 0.875rem;">
                                        <span style="color: #64748b;">{{ $child->name }}</span>
                                        <span
                                            style="color: {{ $branch->color }}; font-weight: 600;">{{ $child->tutorials_count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('tutorials.index', ['branch' => $branch->id]) }}" class="branch-link">Voir les
                            tutoriels →</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection