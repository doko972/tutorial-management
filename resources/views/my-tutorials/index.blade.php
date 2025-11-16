@extends('layouts.app-dashboard')

@section('title', 'Mes tutoriels')
@section('page-title', 'Mes tutoriels')

@section('content')
<div class="dashboard-section">
    <!-- En-tête avec bouton créer -->
    <div class="dashboard-header">
        <div class="dashboard-align">
            <h1 class="dashboard-title">Mes tutoriels</h1>
            <p class="dashboard-subtitle">Gérez vos tutoriels pour la branche {{ auth()->user()->branch->name }}</p>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('my-tutorials.create') }}" class="btn btn-primary btn-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Créer un tutoriel
            </a>
        </div>
    </div>

    <!-- Messages de succès -->
@if(session('success'))
    <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: #d1fae5; border-radius: 0.75rem; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 1rem;">
        <div id="lottie-success" style="width: 60px; height: 60px; flex-shrink: 0;"></div>
        <div style="flex: 1;">
            <div style="font-weight: 600; color: #065f46; margin-bottom: 0.25rem;">Succès !</div>
            <div style="color: #047857; font-size: 0.875rem;">{{ session('success') }}</div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        lottie.loadAnimation({
            container: document.getElementById('lottie-success'),
            renderer: 'svg',
            loop: false,
            autoplay: true,
            path: '/animations/success.json'
        });
    </script>
@endif

    <!-- Liste des tutoriels -->
    @if($tutorials->count() > 0)
        <div class="card" style="overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Titre</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Type</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Statut</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Vues</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; font-size: 0.875rem;">Date</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: #475569; font-size: 0.875rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tutorials as $tutorial)
                        <tr style="border-top: 1px solid #e2e8f0;">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($tutorial->thumbnail)
                                        <img src="{{ Storage::url($tutorial->thumbnail) }}" alt="{{ $tutorial->title }}" style="width: 3rem; height: 3rem; object-fit: cover; border-radius: 0.5rem;">
                                    @else
                                        <div style="width: 3rem; height: 3rem; background: {{ $tutorial->branch->color }}20; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                            <svg style="width: 1.5rem; height: 1.5rem; color: {{ $tutorial->branch->color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 600; color: #0f172a;">{{ $tutorial->title }}</div>
                                        @if($tutorial->description)
                                            <div style="font-size: 0.875rem; color: #64748b; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $tutorial->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #f1f5f9; color: #475569; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
                                    {{ $tutorial->file_type }}
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                @if($tutorial->is_published)
                                    <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0.75rem; background: #d1fae5; color: #065f46; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                        <svg style="width: 0.75rem; height: 0.75rem;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Publié
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0.75rem; background: #fef3c7; color: #92400e; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                        <svg style="width: 0.75rem; height: 0.75rem;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Brouillon
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem; color: #64748b;">
                                {{ $tutorial->views_count }}
                            </td>
                            <td style="padding: 1rem; color: #64748b; font-size: 0.875rem;">
                                {{ $tutorial->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    <a href="{{ route('tutorials.show', $tutorial) }}" class="btn btn-sm" style="background: transparent; color: #3b82f6; border: 1px solid #3b82f6;" title="Voir">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('my-tutorials.edit', $tutorial) }}" class="btn btn-sm" style="background: transparent; color: #f59e0b; border: 1px solid #f59e0b;" title="Modifier">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('my-tutorials.destroy', $tutorial) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tutoriel ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: transparent; color: #ef4444; border: 1px solid #ef4444;" title="Supprimer">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $tutorials->links() }}
        </div>
@else
    <div class="card" style="padding: 4rem 2rem; text-align: center;">
        <div id="lottie-empty" style="width: 350px; height: 350px; margin: 0 auto;"></div>
        <h3 style="font-size: 1.5rem; font-weight: 600; color: #0f172a; margin: 1.5rem 0 0.5rem;">
            Aucun tutoriel pour le moment
        </h3>
        <p style="color: #64748b; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
            Vous n'avez pas encore créé de tutoriel. Commencez dès maintenant à partager vos connaissances avec votre équipe !
        </p>
        <a href="{{ route('my-tutorials.create') }}" class="btn btn-primary btn-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Créer mon premier tutoriel
        </a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        lottie.loadAnimation({
            container: document.getElementById('lottie-empty'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '/animations/empty.json'
        });
    </script>
@endif
</div>
@endsection