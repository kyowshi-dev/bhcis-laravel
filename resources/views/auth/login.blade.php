<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RHU System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen flex items-center justify-center font-sans overflow-hidden">

    <!-- Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-sky-200 via-white to-emerald-200"></div>

    <!-- Soft Glow Effects -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>

    <!-- Login Card -->
    <div class="relative bg-white/70 backdrop-blur-xl p-10 rounded-3xl shadow-2xl w-full max-w-md border border-white/50">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="text-4xl mb-3">🏥</div>
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-sky-600 to-emerald-500 bg-clip-text text-transparent">
                RHU System
            </h1>
            <p class="text-gray-600 mt-2">Secure Access to Healthcare Records</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                    <p class="font-bold">Login Failed</p>
                    <p class="text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            <!-- Username -->
            <div class="mb-5">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>
                <input type="text" name="username" id="username"
                       value="{{ old('username') }}"
                       class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition duration-300 shadow-sm"
                       placeholder="Enter your username" required autofocus>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input type="password" name="password" id="password"
                       class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition duration-300 shadow-sm"
                       placeholder="Enter your password" required>
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember"
                           class="mr-2 h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    Remember me
                </label>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-sky-500 to-emerald-500 text-white font-semibold py-3 rounded-2xl shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300">
                Sign In
            </button>

        </form>

        <!-- Footer -->
        <p class="text-center text-gray-500 text-xs mt-8">
            &copy; {{ date('Y') }} Rural Health Unit Management System  
            <span class="text-sky-600 font-medium">| Community Care First 💙</span>
        </p>

    </div>

</body>
</html>
