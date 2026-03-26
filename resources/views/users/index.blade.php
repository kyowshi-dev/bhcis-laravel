@extends('layouts.app')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-sky-700">User Management</h1>
            <p class="text-xs lg:text-sm text-gray-600 mt-1">
                View and manage all registered users in the system.
            </p>
        </div>

        <a href="{{ route('users.create') }}"
           class="inline-flex items-center justify-center px-4 lg:px-5 py-2 lg:py-2.5 rounded-xl lg:rounded-2xl bg-gradient-to-r from-sky-500 to-emerald-500 text-xs lg:text-sm font-semibold text-white shadow-md hover:shadow-xl transition">
            + Add User
        </a>
    </div>

    <div class="overflow-hidden rounded-xl lg:rounded-2xl border border-gray-200 bg-white/80 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Username</th>
                        <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">Email</th>
                        <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">Registered At</th>
                        <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Role</th>
                        <th class="px-3 lg:px-6 py-2 lg:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-3 lg:px-6 py-2 lg:py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-sky-50/60 transition-colors">
                            <td class="px-3 lg:px-6 py-2 lg:py-3 text-sm text-gray-700">
                                <div class="font-medium">{{ $user->username }}</div>
                                <div class="text-xs text-gray-500 md:hidden">{{ $user->email }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-2 lg:py-3 text-sm text-gray-500 hidden md:table-cell">
                                {{ $user->email }}
                            </td>
                            <td class="px-3 lg:px-6 py-2 lg:py-3 text-sm text-gray-500 hidden lg:table-cell">
                                {{ $user->created_at?->format('M d, Y') }}
                            </td>
                            <td class="px-3 lg:px-6 py-2 lg:py-3 text-sm text-gray-700">
                                {{ $user->roleName() ?? '—' }}
                            </td>
                            <td class="px-3 lg:px-6 py-2 lg:py-3 text-sm">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-2 lg:px-3 py-0.5 lg:py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 lg:px-3 py-0.5 lg:py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                        Disabled
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 lg:px-6 py-2 lg:py-3 text-sm text-right">
                                @if ($user->is_active)
                                    <form action="{{ route('users.disable', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 rounded-full border border-red-300 text-xs font-semibold text-red-600 hover:bg-red-50 transition"
                                            onclick="return confirm('Are you sure you want to disable this user?');"
                                        >
                                            Disable
                                        </button>
                                    </form>
                                @else
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 rounded-full border border-emerald-300 text-xs font-semibold text-emerald-600 hover:bg-emerald-50 transition"
                                        onclick="openEnableModal({{ $user->id }}, '{{ $user->username }}')"
                                    >
                                        Enable
                                    </button>
                                @endif
                                @if (auth()->user()->isAdmin() && $user->id !== auth()->id())
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-1.5 ml-2 rounded-full border border-red-500 text-xs font-semibold text-white bg-red-500 hover:bg-red-600 transition"
                                        onclick="openDeleteModal({{ $user->id }}, '{{ $user->username }}')"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-sm text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm User Deletion</h3>
                <p class="text-sm text-gray-600 mb-4">
                    You are about to permanently delete user <strong id="deleteUsername"></strong>.
                    This action cannot be undone and will remove all associated data.
                </p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Enter your password to confirm
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                            placeholder="Your password"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            onclick="closeDeleteModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 transition"
                        >
                            Delete User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Enable Confirmation Modal -->
<div id="enableModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm User Enable</h3>
                <p class="text-sm text-gray-600 mb-4">
                    You are about to re-enable user <strong id="enableUsername"></strong>.
                    They will regain access to the system.
                </p>

                <form id="enableForm" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="enablePassword" class="block text-sm font-medium text-gray-700 mb-1">
                            Enter your password to confirm
                        </label>
                        <input
                            type="password"
                            id="enablePassword"
                            name="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                            placeholder="Your password"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            onclick="closeEnableModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-lg hover:bg-emerald-700 transition"
                        >
                            Enable User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(userId, username) {
    document.getElementById('deleteUsername').textContent = username;
    document.getElementById('deleteForm').action = `/users/${userId}`;
    document.getElementById('deleteModal').style.display = 'flex';
    document.getElementById('password').focus();
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.getElementById('deleteForm').reset();
}

function openEnableModal(userId, username) {
    document.getElementById('enableUsername').textContent = username;
    document.getElementById('enableForm').action = `/users/${userId}/enable`;
    document.getElementById('enableModal').style.display = 'flex';
    document.getElementById('enablePassword').focus();
}

function closeEnableModal() {
    document.getElementById('enableModal').style.display = 'none';
    document.getElementById('enableForm').reset();
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('enableModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEnableModal();
    }
});
</script>
@endsection
