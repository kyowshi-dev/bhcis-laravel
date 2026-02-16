<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BHCIS - Sta. Ana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-green-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold flex items-center gap-2">
                🏥 BHCIS <span class="text-xs bg-green-800 px-2 py-1 rounded">Sta. Ana</span>
            </a>
            <div class="space-x-4 text-sm flex items-center">
                <a href="{{ url('/patients') }}" class="hover:text-green-200">Patients</a>
                <a href="{{ url('/consultations') }}" class="hover:text-green-200">Consultations</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-green-100 hover:text-white hover:bg-green-800 px-3 py-2 rounded-md text-sm font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="text-center text-gray-400 text-sm py-6">
        &copy; 2026 Barangay Sta. Ana Health Center
    </footer>

</body>
</html>
