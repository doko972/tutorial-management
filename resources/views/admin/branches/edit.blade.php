@extends('layouts.app-dashboard')

@section('title', 'Modifier une branche')
@section('page-title', 'Modifier une branche')

@section('content')
    <div class="dashboard-section">
        <!-- Breadcrumb -->
        <nav style="margin-bottom: 2rem;">
            <ol style="display: flex; gap: 0.5rem; list-style: none; padding: 0; font-size: 0.875rem; color: #64748b;">
                <li><a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Accueil</a></li>
                <li>/</li>
                <li><a href="{{ route('admin.branches.index') }}" style="color: #3b82f6; text-decoration: none;">Branches</a>
                </li>
                <li>/</li>
                <li>Modifier</li>
            </ol>
        </nav>

        <div style="max-width: 700px; margin: 0 auto;">
            <div class="card" style="padding: 2rem;">
                <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">
                    Modifier la branche
                </h1>
                <p style="color: #64748b; margin-bottom: 2rem;">
                    Modifiez les informations de la branche <strong>{{ $branch->name }}</strong>
                </p>

                <form action="{{ route('admin.branches.update', $branch) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom -->
                    <div class="form-group">
                        <label for="name">Nom de la branche *</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') has-error @enderror" value="{{ old('name', $branch->name) }}"
                            required>
                        <span class="form-text">Le slug sera généré automatiquement à partir du nom</span>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') has-error @enderror"
                            rows="3">{{ old('description', $branch->description) }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Couleur -->
                    <div class="form-group">
                        <label for="color">Couleur *</label>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <input type="color" id="color" name="color" value="{{ old('color', $branch->color) }}"
                                required
                                style="width: 4rem; height: 3rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer;">
                            <input type="text" id="color-text" class="form-control"
                                value="{{ old('color', $branch->color) }}" readonly style="flex: 1;">
                        </div>
                        @error('color')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Icône -->
                    <div class="form-group">
                        <label for="icon">Icône (optionnel)</label>
                        <input type="text" id="icon" name="icon"
                            class="form-control @error('icon') has-error @enderror"
                            value="{{ old('icon', $branch->icon) }}" placeholder="Cliquez pour choisir une icône" readonly
                            style="cursor: pointer;" onclick="toggleIconPicker()">
                        @error('icon')
                            <span class="form-error">{{ $message }}</span>
                        @enderror

                        <!-- Icon Picker Popup -->
                        <div id="icon-picker"
                            style="display: none; margin-top: 0.5rem; padding: 1rem; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; max-height: 300px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 0.5rem;">
                                @php
                                    $icons = [
                                        'briefcase',
                                        'phone',
                                        'calculator',
                                        'users',
                                        'user',
                                        'building',
                                        'home',
                                        'settings',
                                        'book',
                                        'file-text',
                                        'folder',
                                        'mail',
                                        'calendar',
                                        'clock',
                                        'shopping-cart',
                                        'dollar-sign',
                                        'credit-card',
                                        'trending-up',
                                        'bar-chart',
                                        'pie-chart',
                                        'package',
                                        'truck',
                                        'globe',
                                        'map-pin',
                                        'star',
                                        'heart',
                                        'award',
                                        'gift',
                                        'tag',
                                        'bookmark',
                                        'bell',
                                        'message-circle',
                                        'send',
                                        'printer',
                                        'download',
                                        'upload',
                                        'database',
                                        'server',
                                        'cpu',
                                        'hard-drive',
                                        'wifi',
                                        'monitor',
                                        'smartphone',
                                        'tablet',
                                        'laptop',
                                        'headphones',
                                        'camera',
                                        'video',
                                        'wrench',
                                        'tool',
                                        'scissors',
                                        'clipboard',
                                        'edit',
                                        'trash',
                                        'search',
                                        'filter',
                                        'check',
                                        'x',
                                        'plus',
                                        'minus',
                                        'shield',
                                        'lock',
                                        'unlock',
                                        'key',
                                        'alert-circle',
                                        'info',
                                        'help-circle',
                                        'check-circle',
                                        'x-circle',
                                        'zap',
                                        'target',
                                        'compass',
                                    ];
                                @endphp
                                @foreach ($icons as $iconName)
                                    <button type="button" onclick="selectIcon('{{ $iconName }}')"
                                        style="padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 0.375rem; background: white; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                                        onmouseover="this.style.borderColor='#6366f1'; this.style.background='#eef2ff'"
                                        onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='white'"
                                        title="{{ $iconName }}">
                                        <i data-lucide="{{ $iconName }}"
                                            style="width: 1.5rem; height: 1.5rem; color: #64748b;"></i>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @push('scripts')
                        <script src="https://unpkg.com/lucide@latest"></script>
                        <script>
                            // Initialiser Lucide icons
                            lucide.createIcons();

                            // Réinitialiser les icônes quand le picker s'ouvre
                            function toggleIconPicker() {
                                const picker = document.getElementById('icon-picker');
                                picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
                                if (picker.style.display === 'block') {
                                    setTimeout(() => lucide.createIcons(), 100);
                                }
                            }
                        </script>
                    @endpush
                    <script>
                        function toggleIconPicker() {
                            const picker = document.getElementById('icon-picker');
                            picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
                        }

                        function selectIcon(iconName) {
                            document.getElementById('icon').value = iconName;
                            toggleIconPicker();
                        }

                        // Fermer le picker si on clique en dehors
                        document.addEventListener('click', function(event) {
                            const picker = document.getElementById('icon-picker');
                            const input = document.getElementById('icon');
                            if (!picker.contains(event.target) && event.target !== input) {
                                picker.style.display = 'none';
                            }
                        });
                    </script>

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
                        <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Synchroniser le color picker avec le champ texte
            const colorPicker = document.getElementById('color');
            const colorText = document.getElementById('color-text');

            colorPicker.addEventListener('input', function() {
                colorText.value = this.value;
            });

            colorText.addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    colorPicker.value = this.value;
                }
            });
        </script>
    @endpush
@endsection
