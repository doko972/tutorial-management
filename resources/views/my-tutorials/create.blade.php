@extends('layouts.app-dashboard')

@section('title', 'Créer un tutoriel')
@section('page-title', 'Créer un tutoriel')

@section('content')
<div class="dashboard-section">
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem;">
        <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
            <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
            <li>/</li>
            <li><a href="{{ route('my-tutorials.index') }}" style="color: #3b82f6; text-decoration: none;">Mes tutoriels</a></li>
            <li>/</li>
            <li>Créer</li>
        </ol>
    </nav>

    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card" style="padding: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">
                Créer un nouveau tutoriel
            </h1>
            <p style="color: #64748b; margin-bottom: 2rem;">
                Remplissez le formulaire ci-dessous pour créer un tutoriel pour la branche <strong>{{ auth()->user()->branch->name }}</strong>
            </p>

            <form action="{{ route('my-tutorials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Titre -->
                <div class="form-group">
                    <label for="title">Titre du tutoriel *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-control @error('title') has-error @enderror" 
                        value="{{ old('title') }}" 
                        required
                        placeholder="Ex: Comment configurer le VPN d'entreprise"
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
                        placeholder="Un résumé rapide de ce tutoriel..."
                    >{{ old('description') }}</textarea>
                    <span class="form-text">Cette description apparaîtra dans la liste des tutoriels</span>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Branche -->
                <div class="form-group">
                    <label for="branch_id">Branche du tutoriel *</label>
                    <select id="branch_id" name="branch_id" class="form-control @error('branch_id') has-error @enderror" required>
                        <option value="">Sélectionnez une branche</option>
                        @foreach($branches as $branch)
                            @if($branch->parent_id === null)
                                <!-- Branche principale -->
                                <optgroup label="📂 {{ $branch->name }}">
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                    
                                    <!-- Sous-branches -->
                                    @foreach($branch->children as $child)
                                        <option value="{{ $child->id }}" {{ old('branch_id') == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;└─ {{ $child->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                    @error('branch_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <small style="display: block; margin-top: 0.5rem; color: #64748b;">
                        Choisissez la branche pour laquelle ce tutoriel est destiné
                    </small>
                </div>
                <!-- Type de fichier -->
                <div class="form-group">
                    <label for="file_type">Type de contenu *</label>
                    <select id="file_type" name="file_type" class="form-control @error('file_type') has-error @enderror" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="text" {{ old('file_type') == 'text' ? 'selected' : '' }}>Texte simple</option>
                        <option value="document" {{ old('file_type') == 'document' ? 'selected' : '' }}>Document Word</option>
                        <option value="pdf" {{ old('file_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="video" {{ old('file_type') == 'video' ? 'selected' : '' }}>Vidéo</option>
                        <option value="link" {{ old('file_type') == 'link' ? 'selected' : '' }}>Lien externe</option>
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
                        class="form-control ckeditor @error('content') has-error @enderror" 
                        rows="10"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

<!-- Choix du type de contenu vidéo -->
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
    <label for="file">Fichier vidéo</label>
    <div style="padding: 1rem; background: #fef3c7; border-radius: 0.5rem; margin-bottom: 1rem; border-left: 4px solid #f59e0b;">
        <p style="font-size: 0.875rem; color: #78350f; margin: 0;">
            ⚠️ <strong>Attention :</strong> Pour les vidéos longues (>5min) ou volumineuses, utilisez plutôt un lien YouTube pour de meilleures performances.
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
            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">
                MP4, AVI, MOV (Max 100MB)
            </div>
        </label>
    </div>
    @error('file')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

<!-- Lien vidéo -->
<div class="form-group" id="video-url-field" style="display: none;">
    <label for="video_url">Lien de la vidéo</label>
    <div style="padding: 1rem; background: #dbeafe; border-radius: 0.5rem; margin-bottom: 1rem; border-left: 4px solid #3b82f6;">
        <p style="font-size: 0.875rem; color: #1e3a8a; margin: 0 0 0.5rem 0;">
            💡 <strong>Astuce :</strong> Utilisez YouTube "Non répertorié" pour garder vos vidéos privées tout en bénéficiant d'un lecteur professionnel.
        </p>
        <p style="font-size: 0.75rem; color: #1e40af; margin: 0;">
            Formats acceptés : YouTube, Vimeo, Dailymotion
        </p>
    </div>
    <input 
        type="url" 
        id="video_url" 
        name="video_url" 
        class="form-control @error('video_url') has-error @enderror" 
        placeholder="https://www.youtube.com/watch?v=..."
        value="{{ old('video_url') }}"
    >
    <span class="form-text">Collez le lien complet de votre vidéo</span>
    @error('video_url')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

<!-- Fichier pour les autres types -->
<div class="form-group" id="file-other-field" style="display: none;">
    <label for="file">Fichier joint</label>
    <div class="file-upload">
        <input type="file" id="file-other" name="file" accept=".doc,.docx,.pdf">
        <label for="file-other" class="file-upload-label">
            <div class="upload-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 3rem; height: 3rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            <div>Cliquez pour sélectionner un fichier</div>
            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">
                Document Word, PDF (Max 50MB)
            </div>
        </label>
    </div>
    <span class="form-text">Le fichier sera disponible en téléchargement sur la page du tutoriel</span>
    @error('file')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

                <!-- Miniature -->
                <div class="form-group">
                    <label for="thumbnail">Image de couverture</label>
                    <div class="file-upload">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                        <label for="thumbnail" class="file-upload-label">
                            <div class="upload-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 3rem; height: 3rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>Cliquez pour sélectionner une image</div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">
                                JPG, PNG, GIF (Max 2MB)
                            </div>
                        </label>
                    </div>
                    @error('thumbnail')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tags par famille -->
                @if($tags->count() > 0)
                <div class="form-group">
                    <label>Tags</label>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @php
                            $tagsByFamily = $tags->groupBy('family');
                        @endphp
                        
                        @foreach($tagsByFamily as $family => $familyTags)
                            <div style="border: 1px solid #e2e8f0; border-radius: 0.5rem; overflow: hidden;">
                                <!-- En-tête de la famille -->
                                <div style="background: #f8fafc; padding: 1rem; border-bottom: 1px solid #e2e8f0; font-weight: 600; color: #0f172a; cursor: pointer;" 
                                    onclick="toggleFamily('family-{{ Str::slug($family) }}')">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span>{{ $family }}</span>
                                        <svg id="icon-family-{{ Str::slug($family) }}" style="width: 1.25rem; height: 1.25rem; transition: transform 0.3s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Tags de la famille -->
                                <div id="family-{{ Str::slug($family) }}" style="padding: 1rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                                    @foreach($familyTags as $tag)
                                        <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                id="tag_{{ $tag->id }}" 
                                                name="tags[]" 
                                                value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                            >
                                            <label for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    </div>
                    <script>
                    function toggleFamily(familyId) {
                        const content = document.getElementById(familyId);
                        const icon = document.getElementById('icon-' + familyId);
                        
                        if (content.style.display === 'none') {
                            content.style.display = 'flex';
                            icon.style.transform = 'rotate(0deg)';
                        } else {
                            content.style.display = 'none';
                            icon.style.transform = 'rotate(-90deg)';
                        }
                    }
                    </script>
                    @endif

                <!-- Publier -->
                <div class="form-group">
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            id="is_published" 
                            name="is_published" 
                            value="1"
                            {{ old('is_published', true) ? 'checked' : '' }}
                        >
                        <label for="is_published">
                            Publier immédiatement
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
                        Créer le tutoriel
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

    let videoTypeSelected = null;

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
        // text et link n'ont pas besoin de fichier
    });

    function selectVideoType(type) {
        videoTypeSelected = type;
        
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

    // Prévisualisation des fichiers
    document.getElementById('file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = e.target.nextElementSibling;
            label.innerHTML = `
                <div class="file-preview">
                    <div class="file-info">
                        <svg style="width: 1.5rem; height: 1.5rem; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>${fileName}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('file').value=''; location.reload();" style="color: #ef4444;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
        }
    });

    document.getElementById('thumbnail').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = e.target.nextElementSibling;
            label.innerHTML = `
                <div class="file-preview">
                    <div class="file-info">
                        <svg style="width: 1.5rem; height: 1.5rem; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>${fileName}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('thumbnail').value=''; location.reload();" style="color: #ef4444;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
        }
    });
</script>
@endpush