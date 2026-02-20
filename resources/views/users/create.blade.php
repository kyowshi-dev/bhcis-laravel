@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-sky-700">Add New User</h1>
            <p class="text-sm text-gray-600 mt-1">
                Create a new staff account for the system.
            </p>
        </div>

        <a href="{{ route('users.index') }}"
           class="inline-flex items-center px-4 py-2 rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
            ← Back to Users
        </a>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Role
                </label>
                <select
                    id="role_id"
                    name="role_id"
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    required
                >
                    <option value="">Select role...</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                    Username
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    required
                >
                @error('username')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    required
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    required
                >
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                    required
                >
            </div>
        </div>

        <div class="pt-4">
            <button
                type="submit"
                class="inline-flex items-center px-6 py-3 rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-emerald-500 shadow-md hover:shadow-xl hover:scale-[1.02] transition"
            >
                Save User
            </button>
        </div>
    </form>
@endsection

