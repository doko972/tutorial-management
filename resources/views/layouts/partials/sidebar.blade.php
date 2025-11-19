<aside class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="landing-logo">
        <div id="logo-header" class="logo-animation"></div>
        <span>HR Télécoms</span>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <!-- Menu principal -->
        <div class="nav-section">
            <div class="nav-section-title">Menu Principal</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="nav-text">Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tutorials.index') }}"
                        class="{{ request()->routeIs('tutorials.*') ? 'active' : '' }}">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="nav-text">Tous les tutoriels</span>
                    </a>
                </li>
                @if (auth()->user()->branch_id)
                    <li class="nav-item">
                        <a href="{{ route('my-tutorials.index') }}"
                            class="{{ request()->routeIs('my-tutorials.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span class="nav-text">Mes tutoriels</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        @if (auth()->user()->isAdmin())
            <!-- Admin -->
            <div class="nav-section">
                <div class="nav-section-title">Administration</div>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <span class="nav-text">Utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.branches.index') }}"
                            class="{{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span class="nav-text">Branches</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </nav>

    <!-- Branches -->
    <div class="sidebar-branches">
        <div class="sidebar-section-title">Branches</div>
        @php
            $branches = \App\Models\Branch::whereNull('parent_id')
                ->with([
                    'children' => function ($query) {
                        $query->withCount('tutorials');
                    }
                ])
                ->get()
                ->map(function ($branch) {
                    // Calculer le total incluant les sous-branches
                    $branch->total_tutorials_count = $branch->tutorials()->count() + $branch->children->sum('tutorials_count');
                    return $branch;
                });
        @endphp
        @foreach ($branches as $branch)
            <div class="branch-group">
                <!-- Branche parente (cliquable pour ouvrir/fermer) -->
                <div class="branch-item branch-parent" onclick="toggleBranch('branch-{{ $branch->id }}')">
                    <div class="branch-color" style="background-color: {{ $branch->color }}"></div>
                    <span class="branch-name">{{ $branch->name }}</span>
                    <span class="branch-count">{{ $branch->total_tutorials_count }}</span>
                    @if ($branch->children->count() > 0)
                        <svg class="branch-chevron" id="chevron-branch-{{ $branch->id }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24"
                            style="width: 1rem; height: 1rem; margin-left: auto; transition: transform 0.3s;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    @endif
                </div>

                <!-- Sous-branches (cachées par défaut) -->
                @if ($branch->children->count() > 0)
                    <div class="branch-children" id="branch-{{ $branch->id }}" style="display: none;">
                        @foreach ($branch->children as $child)
                            <a href="{{ route('tutorials.index', ['branch' => $child->id]) }}"
                                class="branch-item branch-child {{ request('branch') == $child->id ? 'active' : '' }}">
                                <div style="width: 12px;"></div> <!-- Espace pour l'alignement -->
                                <span class="branch-tree">└─</span>
                                <span class="branch-name">{{ $child->name }}</span>
                                <span class="branch-count">{{ $child->tutorials_count }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <script>
        function toggleBranch(branchId) {
            const children = document.getElementById(branchId);
            const chevron = document.getElementById('chevron-' + branchId);

            if (children) {
                if (children.style.display === 'none') {
                    children.style.display = 'block';
                    if (chevron) chevron.style.transform = 'rotate(180deg)';
                } else {
                    children.style.display = 'none';
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            }
        }

        // Ouvrir automatiquement la branche active
        document.addEventListener('DOMContentLoaded', function () {
            const activeChild = document.querySelector('.branch-child.active');
            if (activeChild) {
                const parentId = activeChild.closest('.branch-children').id;
                toggleBranch(parentId);
            }
        });
    </script>
</aside>