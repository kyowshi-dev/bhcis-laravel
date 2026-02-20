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

    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-sky-200 via-white to-emerald-200 animate-pulse opacity-70"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <div class="relative z-10 flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 shrink-0 flex flex-col backdrop-blur-lg bg-white/60 shadow-lg border-r border-white/40">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-6 border-b border-white/40">
                <span class="text-3xl">🏥</span>
                <span class="text-xl font-extrabold bg-gradient-to-r from-sky-600 to-emerald-500 bg-clip-text text-transparent">
                    BHCIS
                </span>
                <span class="text-xs bg-white/70 px-2 py-0.5 rounded-full shadow-sm">Sta. Ana</span>
            </a>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition duration-200">
                    <span>📋</span> Dashboard
                </a>
                <a href="{{ url('/patients') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition duration-200">
                    <span>👥</span> Patients
                </a>
                <a href="{{ route('consultations.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition duration-200">
                    <span>🩺</span> Consultations
                </a>
                <a href="{{ route('reports.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition duration-200">
                    <span>📊</span> Reports
                </a>
                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-white/60 hover:text-sky-600 transition duration-200">
                    <span>👤</span> Users
                </a>
            </nav>
        </aside>

        <!-- Main area: top bar (logout only) + content -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="shrink-0 flex justify-end items-center px-6 py-3 backdrop-blur-md bg-white/50 border-b border-white/40">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-gradient-to-r from-sky-500 to-emerald-500 text-white px-5 py-2 rounded-2xl text-sm font-semibold shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300">
                        Logout
                    </button>
                </form>
            </header>

            <main class="flex-1 px-6 py-8 overflow-auto">
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white/70 backdrop-blur-xl shadow-2xl rounded-3xl p-12 border border-white/50">
                        @yield('content')
                    </div>
                </div>
            </main>

            <footer class="shrink-0 text-center text-gray-600 text-sm py-4 backdrop-blur-md bg-white/50 border-t border-white/40">
                &copy; 2026 Barangay Sta. Ana Health Center
                <span class="text-sky-600 font-medium">| Empowering Community Healthcare 💙</span>
            </footer>
        </div>

    </div>

</body>
</html>
