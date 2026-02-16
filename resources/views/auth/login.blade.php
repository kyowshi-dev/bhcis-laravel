<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RHU System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border border-gray-200">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-700">RHU System</h1>
            <p class="text-gray-500 mt-2">Please sign in to continue</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Login Failed</p>
                    <p class="text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            <div class="mb-5">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" id="username" 
                       value="{{ old('username') }}" 
                       class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" 
                       placeholder="Enter your username" required autofocus>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" 
                       class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" 
                       placeholder="Enter your password" required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    Remember me
                </label>
            </div>

            <button type="submit" class="w-full bg-green-700 text-white font-bold py-3 px-4 rounded hover:bg-green-800 transition duration-200">
                Sign In
            </button>

        </form>
        
        <p class="text-center text-gray-400 text-xs mt-8">
            &copy; {{ date('Y') }} Rural Health Unit Management System
        </p>
    </div>

</body>
</html>