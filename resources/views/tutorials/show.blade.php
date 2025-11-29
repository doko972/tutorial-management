@extends('layouts.app-dashboard')

@section('title', $tutorial->title)
@section('page-title', $tutorial->title)

@section('content')
    <div class="dashboard-section">
        <!-- Breadcrumb -->
        <nav style="margin-bottom: 2rem;">
            <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
                <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
                <li>/</li>
                <li><a href="{{ route('tutorials.index') }}" style="color: #3b82f6; text-decoration: none;">Tutoriels</a></li>
                <li>/</li>
                <li>{{ $tutorial->title }}</li>
            </ol>
        </nav>

        <style>
            @media (min-width: 1024px) {
                .tutorial-layout {
                    grid-template-columns: 2fr 1fr !important;
                }
            }
        </style>

        <div class="tutorial-layout" style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            <!-- Contenu principal -->
            <div>
                <div class="card" style="padding: 2rem;">
                    <!-- En-tête -->
                    <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e2e8f0;">
                        <!-- Badge branche -->
                        <div style="display: inline-block; padding: 0.25rem 0.75rem; background: {{ $tutorial->branch->color }}20; color: {{ $tutorial->branch->color }}; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; margin-bottom: 1rem;">
                            {{ $tutorial->branch->name }}
                        </div>

                        <h1 style="font-size: 2rem; font-weight: 700; color: #0f172a; margin-bottom: 1rem;">
                            {{ $tutorial->title }}
                        </h1>

                        <!-- Meta informations -->
                        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.875rem; color: #64748b;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ $tutorial->author->name }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $tutorial->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>{{ $tutorial->views_count }} vue(s)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Miniature -->
                    @if ($tutorial->thumbnail)
                        <img src="{{ Storage::url($tutorial->thumbnail) }}" alt="{{ $tutorial->title }}"
                            style="width: 50%; height: auto; border-radius: 0.75rem; margin-bottom: 2rem;">
                    @endif

                    <!-- Description -->
                    @if ($tutorial->description)
                        <div style="margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; border-left: 4px solid {{ $tutorial->branch->color }};">
                            <p style="font-size: 1.125rem; color: #475569; line-height: 1.7; margin: 0;">
                                {{ $tutorial->description }}
                            </p>
                        </div>
                    @endif

                    <!-- Contenu -->
                    @if($tutorial->content)
                        <div style="margin-bottom: 2rem; line-height: 1.8; color: #334155;">
                            {!! $tutorial->content !!}
                        </div>
                    @endif

                    <!-- Fichier joint ou vidéo -->
                    @if($tutorial->file_path || $tutorial->video_url)
                        <div style="margin-top: 2rem; padding: 1.5rem; background: #f1f5f9; border-radius: 0.75rem;">
                            @if($tutorial->video_url)
                                <!-- Vidéo embed (YouTube/Vimeo) -->
                                <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem;">
                                    📹 Vidéo du tutoriel
                                </h3>
                                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 0.5rem;">
                                    @php
                                        $videoUrl = $tutorial->video_url;
                                        $embedUrl = '';
                                        
                                        // YouTube
                                        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $matches) || preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $matches)) {
                                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                        }
                                        // Vimeo
                                        elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
                                            $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                        }
                                        // Dailymotion
                                        elseif (preg_match('/dailymotion\.com\/video\/([^_]+)/', $videoUrl, $matches)) {
                                            $embedUrl = 'https://www.dailymotion.com/embed/video/' . $matches[1];
                                        }
                                    @endphp
                                    
                                    @if($embedUrl)
                                        <iframe 
                                            src="{{ $embedUrl }}" 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                            allowfullscreen
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        ></iframe>
                                    @else
                                        <div style="padding: 2rem; text-align: center; background: white; border-radius: 0.5rem;">
                                            <p style="margin-bottom: 1rem; color: #64748b;">Impossible d'intégrer cette vidéo automatiquement.</p>
                                            <a href="{{ $tutorial->video_url }}" target="_blank" class="btn btn-primary">
                                                Ouvrir la vidéo
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @elseif($tutorial->file_path)
                                @php
                                    $extension = pathinfo($tutorial->file_path, PATHINFO_EXTENSION);
                                    $isPdf = strtolower($extension) === 'pdf';
                                @endphp
                                
                                <!-- Titre avec actions -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin: 0;">
                                        📁 Fichier joint
                                    </h3>
                                    <div style="display: flex; gap: 0.5rem;">
                                        @if($isPdf)
                                            <button onclick="togglePdfViewer()" class="btn btn-sm" style="background: #3b82f6; color: white;">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span id="viewer-toggle-text">Afficher</span>
                                            </button>
                                        @else
                                            <!-- Pour Word/Excel : Ouvrir directement -->
                                            <a href="{{ Storage::url($tutorial->file_path) }}" target="_blank" class="btn btn-sm" style="background: #3b82f6; color: white;">
                                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                Ouvrir
                                            </a>
                                        @endif
                                        <a href="{{ Storage::url($tutorial->file_path) }}" download class="btn btn-sm" style="background: #10b981; color: white;">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Télécharger
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Info fichier -->
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 3rem; height: 3rem; background: {{ $tutorial->branch->color }}20; color: {{ $tutorial->branch->color }}; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                            <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div style="font-weight: 500; color: #0f172a;">{{ basename($tutorial->file_path) }}</div>
                                            <div style="font-size: 0.875rem; color: #64748b;">
                                                {{ strtoupper($extension) }} • {{ number_format($tutorial->file_size / 1024, 2) }} KB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Viewer PDF (caché par défaut) -->
                                @if($isPdf)
                                    <div id="pdf-viewer" style="display: none; margin-top: 1rem;">
                                        <iframe 
                                            src="{{ Storage::url($tutorial->file_path) }}" 
                                            style="width: 100%; height: 800px; border: 1px solid #e2e8f0; border-radius: 0.5rem;"
                                            type="application/pdf"
                                        ></iframe>
                                    </div>
                                    
                                    <script>
                                        function togglePdfViewer() {
                                            const viewer = document.getElementById('pdf-viewer');
                                            const toggleText = document.getElementById('viewer-toggle-text');
                                            
                                            if (viewer.style.display === 'none') {
                                                viewer.style.display = 'block';
                                                toggleText.textContent = 'Masquer';
                                            } else {
                                                viewer.style.display = 'none';
                                                toggleText.textContent = 'Afficher';
                                            }
                                        }
                                    </script>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Actions -->
                @can('update', $tutorial)
                    <div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem;">Actions</h3>
                        <div style="display: flex; flex-direction: row; gap: 0.75rem;">
                            <a href="{{ route('my-tutorials.edit', $tutorial) }}" class="btn btn-primary" style="flex: 1;">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier
                            </a>
                            <form action="{{ route('my-tutorials.destroy', $tutorial) }}" method="POST" style="flex: 1;"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tutoriel ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 100%;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan

                <!-- Tutoriels similaires -->
                @if ($relatedTutorials->count() > 0)
                    <div class="card" style="padding: 1.5rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem;">
                            Tutoriels similaires
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach ($relatedTutorials as $related)
                                <a href="{{ route('tutorials.show', $related) }}"
                                    style="display: block; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; text-decoration: none; transition: background 0.3s;"
                                    onmouseover="this.style.background='#f1f5f9'"
                                    onmouseout="this.style.background='#f8fafc'">
                                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #0f172a; margin-bottom: 0.5rem;">
                                        {{ $related->title }}
                                    </h4>
                                    <p style="font-size: 0.75rem; color: #64748b; margin: 0;">
                                        {{ $related->author->name }} • {{ $related->views_count }} vue(s)
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection