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

    <!-- Soft Glow Circles -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <!-- Content Wrapper -->
    <div class="relative z-10 flex flex-col min-h-screen">

        <!-- Navbar -->
        <nav class="backdrop-blur-lg bg-white/60 shadow-lg sticky top-0 border-b border-white/40">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">

                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="text-3xl">🏥</span>
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 to-emerald-500 bg-clip-text text-transparent">
                        BHCIS
                    </span>
                    <span class="text-xs bg-white/70 px-3 py-1 rounded-full shadow-sm">
                        Sta. Ana
                    </span>
                </a>

                <div class="space-x-8 text-sm font-medium flex items-center">
                    <a href="{{ url('/patients') }}" 
                       class="relative hover:text-sky-600 transition duration-300">
                        Patients
                    </a>

                    <a href="{{ url('/consultations') }}" 
                       class="relative hover:text-sky-600 transition duration-300">
                        Consultations
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                            class="bg-gradient-to-r from-sky-500 to-emerald-500 text-white px-6 py-2 rounded-2xl shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-14 flex-grow">
            <div class="bg-white/70 backdrop-blur-xl shadow-2xl rounded-3xl p-12 border border-white/50">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center text-gray-600 text-sm py-6 backdrop-blur-md bg-white/50 border-t border-white/40">
            &copy; 2026 Barangay Sta. Ana Health Center  
            <span class="text-sky-600 font-medium">| Empowering Community Healthcare 💙</span>
        </footer>

    </div>

</body>
</html>
