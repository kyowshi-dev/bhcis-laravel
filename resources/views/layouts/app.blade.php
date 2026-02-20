<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BHCIS - Sta. Ana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sannpm run builds antialiased overflow-hidden">

    <div class="flex h-screen w-full">

        <aside id="sidebar" class="bg-green-700 text-white w-64 flex-shrink-0 flex flex-col transition-all duration-300 shadow-xl relative">
            
            <div class="h-16 flex items-center justify-between px-4 border-b border-green-600">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 overflow-hidden whitespace-nowrap hover:text-green-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span id="logo-text" class="font-bold text-xl tracking-wider transition-opacity duration-300">BHCIS</span>
                </a>
                
                <button onclick="toggleSidebar()" class="p-1 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 py-4 flex flex-col gap-2 px-3 overflow-y-auto">
                
                <a href="{{ route('patients.index') }}" class="flex items-center px-3 py-3 rounded-md hover:bg-green-600 transition-colors {{ request()->routeIs('patients.*') ? 'bg-green-800 shadow-inner' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="ml-3 sidebar-text whitespace-nowrap transition-opacity duration-300">Patients</span>
                </a>

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
    </script>
</body>
</html>