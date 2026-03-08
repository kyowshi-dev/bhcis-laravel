<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BHCIS') - Sta. Ana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400&family=Source+Sans+3:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --font-display: 'Fraunces', Georgia, serif;
            --font-body: 'Source Sans 3', system-ui, sans-serif;
            --bg-page: #f5f0e8;
            --bg-surface: #fdfcfa;
            --bg-surface-elevated: #ffffff;
            --ink: #1a1f1c;
            --ink-muted: #5c6560;
            --ink-subtle: #8a928d;
            --border: rgba(26, 31, 28, 0.12);
            --primary: #0d4a3c;
            --primary-hover: #0a3d32;
            --accent: #c45c41;
            --accent-hover: #a84d36;
            --accent-soft: rgba(196, 92, 65, 0.12);
            --teal-soft: rgba(13, 74, 60, 0.08);
            --shadow-sm: 0 1px 2px rgba(26, 31, 28, 0.06);
            --shadow-md: 0 4px 12px rgba(26, 31, 28, 0.08);
            --shadow-lg: 0 12px 32px rgba(26, 31, 28, 0.1);
            --radius: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .grain::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in {
            animation: fadeSlideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .delay-3 { animation-delay: 0.15s; }
        .delay-4 { animation-delay: 0.2s; }
        .delay-5 { animation-delay: 0.25s; }
        .delay-6 { animation-delay: 0.3s; }
        .opacity-0 { opacity: 0; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Fraunces', 'Georgia', 'serif'],
                        sans: ['Source Sans 3', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        ink: '#1a1f1c',
                        'ink-muted': '#5c6560',
                        primary: '#0d4a3c',
                        accent: '#c45c41',
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen overflow-x-hidden font-sans text-[var(--ink)] antialiased" style="background: var(--bg-page);">
    <div class="grain fixed inset-0 z-0"></div>
    <div class="absolute inset-0 z-0 opacity-40" style="background: linear-gradient(135deg, var(--teal-soft) 0%, transparent 50%, rgba(196,92,65,0.06) 100%);"></div>

    <div class="relative z-10 flex min-h-screen" x-data="{ sidebarOpen: false }">
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/40 lg:hidden" style="display: none;"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed lg:static inset-y-0 left-0 w-64 shrink-0 flex flex-col z-50 transition-transform duration-300 ease-out border-r border-[var(--border)]" style="background: var(--bg-surface-elevated); box-shadow: var(--shadow-md);">
            <div class="flex items-center justify-between p-4 lg:p-5 border-b border-[var(--border)]">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg text-white font-display font-semibold text-sm" style="background: var(--primary);">B</span>
                    <span class="font-display font-semibold text-lg" style="color: var(--ink);">BHCIS</span>
                    <span class="text-[10px] font-medium uppercase tracking-wider px-2 py-0.5 rounded" style="background: var(--teal-soft); color: var(--primary);">Sta. Ana</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg hover:bg-black/5 transition-[background]" style="color: var(--ink-muted);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

<<<<<<< HEAD
            <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
                @php
                    /** @var \App\Models\User|null $authUser */
                    $authUser = auth()->user();
                @endphp

                <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                    <span class="text-base opacity-70">📋</span> <span>Dashboard</span>
                </a>
                <a href="{{ route('households.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                    <span class="text-base opacity-70">🏠</span> <span>Households</span>
                </a>
                <a href="{{ url('/patients') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                    <span class="text-base opacity-70">👥</span> <span>Patients</span>
                </a>
                <a href="{{ route('consultations.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                    <span class="text-base opacity-70">🩺</span> <span>Consultations</span>
                </a>
                <a href="{{ route('immunizations.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                    <span class="text-base opacity-70">💉</span> <span>Immunization</span>
                </a>
                @if ($authUser && $authUser->hasRole('Admin', 'BHW', 'Nurse'))
                    <a href="{{ route('reports.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                        <span class="text-base opacity-70">📊</span> <span>Reports</span>
                    </a>
                @endif

                @if ($authUser && $authUser->isAdmin())
                    <a href="{{ route('users.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                        <span class="text-base opacity-70">👤</span> <span>Users</span>
                    </a>
                @endif
                <a href="{{ route('settings.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-[background,color] duration-200" style="color: var(--ink-muted);">
                    <span class="text-base opacity-70">⚙️</span> <span>Settings</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="shrink-0 flex justify-between items-center px-4 lg:px-6 py-3 border-b border-[var(--border)]" style="background: var(--bg-surface);">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-black/5 transition-[background]" style="color: var(--ink-muted);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="ml-auto flex items-center gap-4">
                    @if ($authUser)
                        <div class="hidden sm:flex flex-col items-end text-xs leading-tight">
                            <span class="font-semibold" style="color: var(--ink);">
                                {{ $authUser->username }}
                            </span>
                            <span style="color: var(--ink-muted);">
                                Role: {{ $authUser->roleName() ?? 'Unassigned' }}
                            </span>
                        </div>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold text-white transition-[background,transform] duration-200 hover:scale-[1.02] active:scale-[0.98]" style="background: var(--accent); box-shadow: var(--shadow-sm);">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 px-4 lg:px-6 py-6 lg:py-8 overflow-auto">
                <div class="max-w-5xl mx-auto">
                    <div class="rounded-2xl p-5 lg:p-8 border border-[var(--border)] animate-in opacity-0" style="background: var(--bg-surface-elevated); box-shadow: var(--shadow-sm);">
                        @yield('content')
                    </div>
                </div>
            </main>

            <footer class="shrink-0 text-center py-3 text-xs border-t border-[var(--border)]" style="background: var(--bg-surface); color: var(--ink-subtle);">
                &copy; {{ date('Y') }} Barangay Sta. Ana Health Center
                <span class="font-medium hidden sm:inline" style="color: var(--primary);"> — Community care</span>
            </footer>
        </div>
    </div>

    <style>
        .nav-link:hover { background: var(--teal-soft); color: var(--primary) !important; }
        a[href="{{ request()->url() }}"].nav-link,
        .nav-link.router-link-active { background: var(--teal-soft); color: var(--primary) !important; }
    </style>
    <script>
        document.querySelectorAll('.nav-link').forEach(function(link) {
            var href = link.getAttribute('href') || '';
            var path = href.replace(/^https?:\/\/[^/]+/, '').replace(/\/$/, '') || '/';
            var current = window.location.pathname.replace(/\/$/, '') || '/';
            if (path === current) link.classList.add('router-link-active');
        });
=======
                <a href="#" class="flex items-center px-3 py-3 rounded-md hover:bg-green-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="ml-3 sidebar-text whitespace-nowrap transition-opacity duration-300">Consultations</span>
                </a>

            </nav>

            <div class="border-t border-green-600 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-1 py-2 text-green-100 hover:text-white hover:bg-green-600 rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="ml-3 sidebar-text whitespace-nowrap transition-opacity duration-300">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            <header class="h-16 bg-white shadow-sm flex items-center px-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Sta. Ana Health Center</h2>
            </header>

            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>
        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const texts = document.querySelectorAll('.sidebar-text');
            const logoText = document.getElementById('logo-text');
            
            // Toggle the width of the sidebar
            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20'); // Collapsed width
                
                // Hide text
                logoText.classList.add('opacity-0', 'hidden');
                texts.forEach(text => {
                    text.classList.add('opacity-0', 'hidden');
                });
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64'); // Expanded width
                
                // Show text
                logoText.classList.remove('opacity-0', 'hidden');
                texts.forEach(text => {
                    text.classList.remove('opacity-0', 'hidden');
                });
            }
        }
>>>>>>> 1c8ef6da3b73bbfb3c5e5a4276720419b477f5d7
    </script>
</body>
</html>