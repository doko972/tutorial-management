@extends('layouts.app-dashboard')

@section('title', 'Modifier un tutoriel')
@section('page-title', 'Modifier un tutoriel')

@section('content')
<div class="dashboard-section">
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem;">
        <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
            <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
            <li>/</li>
            <li><a href="{{ route('my-tutorials.index') }}" style="color: #3b82f6; text-decoration: none;">Mes tutoriels</a></li>
            <li>/</li>
            <li>Modifier</li>
        </ol>
    </nav>

    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card" style="padding: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">
                Modifier le tutoriel
            </h1>
            <p style="color: #64748b; margin-bottom: 2rem;">
                Modifiez les informations de votre tutoriel
            </p>

            <form action="{{ route('my-tutorials.update', $myTutorial) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="form-group">
                    <label for="title">Titre du tutoriel *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-control @error('title') has-error @enderror" 
                        value="{{ old('title', $myTutorial->title) }}" 
                        required
                    >
                    @error('title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description courte</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-control @error('description') has-error @enderror" 
                        rows="3"
                    >{{ old('description', $myTutorial->description) }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Type de fichier -->
                <div class="form-group">
                    <label for="file_type">Type de contenu *</label>
                    <select id="file_type" name="file_type" class="form-control @error('file_type') has-error @enderror" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="text" {{ old('file_type', $myTutorial->file_type) == 'text' ? 'selected' : '' }}>Texte simple</option>
                        <option value="document" {{ old('file_type', $myTutorial->file_type) == 'document' ? 'selected' : '' }}>Document Word</option>
                        <option value="pdf" {{ old('file_type', $myTutorial->file_type) == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="video" {{ old('file_type', $myTutorial->file_type) == 'video' ? 'selected' : '' }}>Vidéo</option>
                        <option value="link" {{ old('file_type', $myTutorial->file_type) == 'link' ? 'selected' : '' }}>Lien externe</option>
                    </select>
                    @error('file_type')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contenu texte -->
                <div class="form-group">
                    <label for="content">Contenu du tutoriel</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        class="form-control @error('content') has-error @enderror" 
                        rows="10"
                    >{{ old('content', $myTutorial->content) }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Fichier actuel -->
                @if($myTutorial->file_path)
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; border-left: 4px solid #3b82f6;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 1.5rem; height: 1.5rem; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <div style="font-weight: 500; color: #0f172a; font-size: 0.875rem;">Fichier actuel</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">{{ basename($myTutorial->file_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ Storage::url($myTutorial->file_path) }}" target="_blank" style="color: #3b82f6; font-size: 0.875rem; text-decoration: none;">
                                Télécharger
                            </a>
                        </div>
                    </div>
                @endif

                <!-- URL vidéo actuelle -->
                @if($myTutorial->video_url)
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fef2f2; border-radius: 0.5rem; border-left: 4px solid #ef4444;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 1.5rem; height: 1.5rem; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <div>
                                    <div style="font-weight: 500; color: #0f172a; font-size: 0.875rem;">Lien vidéo actuel</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">{{ $myTutorial->video_url }}</div>
                                </div>
                            </div>
                            <a href="{{ $myTutorial->video_url }}" target="_blank" style="color: #ef4444; font-size: 0.875rem; text-decoration: none;">
                                Voir
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Choix du type de contenu vidéo (si c'est une vidéo) -->
                <div class="form-group" id="video-choice-field" style="display: none;">
                    <label>Type de contenu vidéo</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div style="padding: 1.5rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s;" onclick="selectVideoType('upload')" id="video-upload-option">
                            <div style="text-align: center;">
                                <svg style="width: 3rem; height: 3rem; margin: 0 auto 0.5rem; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Uploader une vidéo</h4>
                                <p style="font-size: 0.875rem; color: #64748b; margin: 0;">Pour les vidéos courtes et confidentielles (max 100MB)</p>
                            </div>
                        </div>
                        <div style="padding: 1.5rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s;" onclick="selectVideoType('link')" id="video-link-option">
                            <div style="text-align: center;">
                                <svg style="width: 3rem; height: 3rem; margin: 0 auto 0.5rem; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Lien YouTube/Vimeo</h4>
                                <p style="font-size: 0.875rem; color: #64748b; margin: 0;">Recommandé pour les longues vidéos et formations</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload vidéo -->
                <div class="form-group" id="file-upload-field" style="display: none;">
                    <label for="file">{{ $myTutorial->file_path ? 'Remplacer la vidéo' : 'Fichier vidéo' }}</label>
                    <div style="padding: 1rem; background: #fef3c7; border-radius: 0.5rem; margin-bottom: 1rem; border-left: 4px solid #f59e0b;">
                        <p style="font-size: 0.875rem; color: #78350f; margin: 0;">
                            ⚠️ <strong>Attention :</strong> Pour les vidéos longues (>5min) ou volumineuses, utilisez plutôt un lien YouTube.
                        </p>
                    </div>
                    <div class="file-upload">
                        <input type="file" id="file" name="file" accept=".mp4,.avi,.mov,.mkv">
                        <label for="file" class="file-upload-label">
                            <div class="upload-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 3rem; height: 3rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <div>Cliquez pour sélectionner une vidéo</div>
                        </label>
                    </div>
                    @error('file')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Lien vidéo -->
                <div class="form-group" id="video-url-field" style="display: none;">
                    <label for="video_url">{{ $myTutorial->video_url ? 'Modifier le lien de la vidéo' : 'Lien de la vidéo' }}</label>
                    <div style="padding: 1rem; background: #dbeafe; border-radius: 0.5rem; margin-bottom: 1rem; border-left: 4px solid #3b82f6;">
                        <p style="font-size: 0.875rem; color: #1e3a8a; margin: 0 0 0.5rem 0;">
                            💡 <strong>Astuce :</strong> Utilisez YouTube "Non répertorié" pour garder vos vidéos privées.
                        </p>
                    </div>
                    <input 
                        type="url" 
                        id="video_url" 
                        name="video_url" 
                        class="form-control @error('video_url') has-error @enderror" 
                        placeholder="https://www.youtube.com/watch?v=..."
                        value="{{ old('video_url', $myTutorial->video_url) }}"
                    >
                    @error('video_url')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Fichier pour les autres types -->
                <div class="form-group" id="file-other-field" style="display: none;">
                    <label for="file-other">{{ $myTutorial->file_path ? 'Remplacer le fichier' : 'Fichier joint' }}</label>
                    <div class="file-upload">
                        <input type="file" id="file-other" name="file" accept=".doc,.docx,.pdf">
                        <label for="file-other" class="file-upload-label">
                            <div class="upload-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 3rem; height: 3rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <div>Cliquez pour sélectionner un fichier</div>
                        </label>
                    </div>
                    @error('file')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Miniature actuelle -->
                @if($myTutorial->thumbnail)
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Image de couverture actuelle</label>
                        <img src="{{ Storage::url($myTutorial->thumbnail) }}" alt="{{ $myTutorial->title }}" style="max-width: 300px; height: auto; border-radius: 0.5rem; border: 2px solid #e2e8f0;">
                    </div>
                @endif

                <!-- Nouvelle miniature -->
                <div class="form-group">
                    <label for="thumbnail">{{ $myTutorial->thumbnail ? 'Remplacer l\'image de couverture' : 'Image de couverture' }}</label>
                    <div class="file-upload">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                        <label for="thumbnail" class="file-upload-label">
                            <div class="upload-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 3rem; height: 3rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>Cliquez pour sélectionner une image</div>
                        </label>
                    </div>
                    @error('thumbnail')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tags -->
                @if($tags->count() > 0)
                <div class="form-group">
                    <label>Tags</label>
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        @foreach($tags as $tag)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    id="tag_{{ $tag->id }}" 
                                    name="tags[]" 
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', $myTutorial->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                >
                                <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                @endif

                <!-- Publier -->
                <div class="form-group">
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            id="is_published" 
                            name="is_published" 
                            value="1"
                            {{ old('is_published', $myTutorial->is_published) ? 'checked' : '' }}
                        >
                        <label for="is_published">
                            Publier
                            <span style="display: block; font-size: 0.875rem; color: #64748b; font-weight: normal; margin-top: 0.25rem;">
                                Si décoché, le tutoriel sera sauvegardé en brouillon
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Boutons -->
                <div style="display: flex; gap: 1rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-primary btn-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 1.25rem; height: 1.25rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('my-tutorials.index') }}" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Gestion du changement de type de fichier
    const fileTypeSelect = document.getElementById('file_type');
    const videoChoiceField = document.getElementById('video-choice-field');
    const fileUploadField = document.getElementById('file-upload-field');
    const videoUrlField = document.getElementById('video-url-field');
    const fileOtherField = document.getElementById('file-other-field');

    // Afficher les bons champs au chargement de la page
    window.addEventListener('DOMContentLoaded', function() {
        const currentType = fileTypeSelect.value;
        if (currentType === 'video') {
            videoChoiceField.style.display = 'block';
        } else if (currentType === 'document' || currentType === 'pdf') {
            fileOtherField.style.display = 'block';
        }
    });

    fileTypeSelect.addEventListener('change', function() {
        // Cacher tous les champs
        videoChoiceField.style.display = 'none';
        fileUploadField.style.display = 'none';
        videoUrlField.style.display = 'none';
        fileOtherField.style.display = 'none';

        // Afficher le bon champ selon le type
        if (this.value === 'video') {
            videoChoiceField.style.display = 'block';
        } else if (this.value === 'document' || this.value === 'pdf') {
            fileOtherField.style.display = 'block';
        }
    });

    function selectVideoType(type) {
        // Réinitialiser les styles
        document.getElementById('video-upload-option').style.borderColor = '#e2e8f0';
        document.getElementById('video-upload-option').style.background = 'white';
        document.getElementById('video-link-option').style.borderColor = '#e2e8f0';
        document.getElementById('video-link-option').style.background = 'white';

        if (type === 'upload') {
            document.getElementById('video-upload-option').style.borderColor = '#3b82f6';
            document.getElementById('video-upload-option').style.background = '#eff6ff';
            fileUploadField.style.display = 'block';
            videoUrlField.style.display = 'none';
        } else if (type === 'link') {
            document.getElementById('video-link-option').style.borderColor = '#ef4444';
            document.getElementById('video-link-option').style.background = '#fef2f2';
            videoUrlField.style.display = 'block';
            fileUploadField.style.display = 'none';
        }
    }
</script>
@endpush
@endsection