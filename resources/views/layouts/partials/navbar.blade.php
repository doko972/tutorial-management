<nav class="navbar" id="navbar">
    <div class="navbar-left">
        <!-- Toggle Sidebar Button -->
        <button class="navbar-toggle" id="sidebar-toggle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <div class="navbar-title">
            @yield('page-title', 'Dashboard')
        </div>
    </div>

    <div class="navbar-right">
        <!-- Search Bar -->
        <div class="navbar-search">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" placeholder="Rechercher un tutoriel...">
        </div>

        <!-- Notifications -->
        <div class="navbar-notifications">
            <button id="notifications-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="notification-badge"></span>
                @endif
            </button>

            <!-- Dropdown des notifications -->
            <div id="notifications-dropdown"
                style="display: none; position: absolute; top: 100%; right: 0; margin-top: 0.5rem; width: 400px; max-width: 90vw; background: white; border-radius: 0.75rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); z-index: 1000; max-height: 500px; overflow-y: auto;">
                <div
                    style="padding: 1rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-weight: 600; color: #0f172a; margin: 0;">Notifications</h3>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit"
                                style="font-size: 0.75rem; color: #3b82f6; background: none; border: none; cursor: pointer; text-decoration: underline;">
                                Tout marquer comme lu
                            </button>
                        </form>
                    @endif
                </div>

                <div style="max-height: 400px; overflow-y: auto;">
                    @forelse(auth()->user()->notifications()->latest()->limit(10)->get() as $notification)
                        <a href="{{ route('tutorials.show', $notification->data['tutorial_slug']) }}?notification={{ $notification->id }}"
                            style="display: block; padding: 1rem; border-bottom: 1px solid #e2e8f0; text-decoration: none; transition: background 0.3s; {{ $notification->read_at ? 'opacity: 0.6;' : 'background: #f0f9ff;' }}"
                            onmouseover="this.style.background='#f8fafc'"
                            onmouseout="this.style.background='{{ $notification->read_at ? 'white' : '#f0f9ff' }}'">

                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <div
                                    style="width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; background: {{ $notification->data['branch_color'] }}20; color: {{ $notification->data['branch_color'] }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <p
                                        style="font-weight: 500; color: #0f172a; margin: 0 0 0.25rem 0; font-size: 0.875rem;">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <p style="font-size: 0.75rem; color: #64748b; margin: 0;">
                                        Par {{ $notification->data['author_name'] }} •
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if(!$notification->read_at)
                                    <div
                                        style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%; flex-shrink: 0; margin-top: 0.5rem;">
                                    </div>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div style="padding: 2rem; text-align: center;">
                            <div id="lottie-no-notifications" style="width: 150px; height: 150px; margin: 0 auto;"></div>
                            <p style="font-size: 0.875rem; color: #94a3b8; margin-top: 0.5rem;">Aucune notification</p>
                        </div>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
                        <script>
                            if (document.getElementById('lottie-no-notifications')) {
                                lottie.loadAnimation({
                                    container: document.getElementById('lottie-no-notifications'),
                                    renderer: 'svg',
                                    loop: true,
                                    autoplay: true,
                                    path: '/animations/no-notifications.json'
                                });
                            }
                        </script>
                    @endforelse
                </div>

                @if(auth()->user()->notifications->count() > 10)
                    <div style="padding: 0.75rem; text-align: center; border-top: 1px solid #e2e8f0;">
                        <a href="#" style="font-size: 0.875rem; color: #3b82f6; text-decoration: none; font-weight: 500;">
                            Voir toutes les notifications
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- User Menu -->
        <div class="navbar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">
                    @if(auth()->user()->isAdmin())
                        Administrateur
                    @elseif(auth()->user()->isManager())
                        Manager
                    @else
                        Utilisateur
                    @endif
                    @if(auth()->user()->branch)
                        - {{ auth()->user()->branch->name }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline btn-sm">
                <svg class="nav-icon" style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </button>
        </form>
    </div>
</nav>

@push('scripts')
    <script>
        // Toggle Sidebar
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const dashboardContent = document.getElementById('dashboard-content');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('sidebar-collapsed');
            dashboardContent.classList.toggle('sidebar-collapsed');
        });

        // Toggle Notifications Dropdown
        const notificationsBtn = document.getElementById('notifications-btn');
        const notificationsDropdown = document.getElementById('notifications-dropdown');

        if (notificationsBtn && notificationsDropdown) {
            notificationsBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationsDropdown.style.display = notificationsDropdown.style.display === 'none' ? 'block' : 'none';
            });

            // Fermer le dropdown si on clique ailleurs
            document.addEventListener('click', (e) => {
                if (!notificationsDropdown.contains(e.target) && e.target !== notificationsBtn) {
                    notificationsDropdown.style.display = 'none';
                }
            });
        }
    </script>
@endpush