<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BHCIS - Sta. Ana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="relative min-h-screen font-sans text-gray-800 overflow-x-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-sky-200 via-white to-emerald-200 animate-pulse opacity-70"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="relative z-10 flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed lg:static inset-y-0 left-0 w-64 shrink-0 flex flex-col backdrop-blur-lg bg-white/60 shadow-lg border-r border-white/40 z-50 transition-transform duration-300">
            <div class="flex items-center justify-between p-4 lg:p-6 border-b border-white/40">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 lg:gap-3">
                    <span class="text-2xl lg:text-3xl">🏥</span>
                    <span class="text-lg lg:text-xl font-extrabold bg-gradient-to-r from-sky-600 to-emerald-500 bg-clip-text text-transparent">
                        BHCIS
                    </span>
                    <span class="text-xs bg-white/70 px-2 py-0.5 rounded-full shadow-sm hidden sm:inline">Sta. Ana</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden p-1 text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></svg>
                </button>
            </div>

            <nav class="flex-1 p-2 lg:p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition">
                    <span>📋</span> <span>Dashboard</span>
                </a>
                <a href="{{ url('/patients') }}" class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition">
                    <span>👥</span> <span>Patients</span>
                </a>
                <a href="{{ route('consultations.index') }}" class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition">
                    <span>🩺</span> <span>Consultations</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition">
                    <span>📊</span> <span>Reports</span>
                </a>
                <a href="{{ route('users.index') }}" class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition">
                    <span>👤</span> <span>Users</span>
                </a>
            </nav>
        </aside>

        <!-- Main area -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="shrink-0 flex justify-between items-center px-3 lg:px-6 py-2 lg:py-3 backdrop-blur-md bg-white/50 border-b border-white/40">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></svg>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-sky-500 to-emerald-500 text-white px-4 lg:px-5 py-1.5 lg:py-2 rounded-xl lg:rounded-2xl text-xs lg:text-sm font-semibold shadow-md hover:shadow-xl transition">
                        Logout
                    </button>
                </form>
            </header>

            <main class="flex-1 px-3 lg:px-6 py-4 lg:py-8 overflow-auto">
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white/70 backdrop-blur-xl shadow-xl lg:shadow-2xl rounded-2xl lg:rounded-3xl p-4 lg:p-8 xl:p-12 border border-white/50">
                        @yield('content')
                    </div>
                </div>
            </main>

            <footer class="shrink-0 text-center text-gray-600 text-xs lg:text-sm py-3 lg:py-4 backdrop-blur-md bg-white/50 border-t border-white/40">
                &copy; 2026 Barangay Sta. Ana Health Center
                <span class="text-sky-600 font-medium hidden sm:inline">| Empowering Community Healthcare 💙</span>
            </footer>
        </div>
    </div>
</body>
</html>
