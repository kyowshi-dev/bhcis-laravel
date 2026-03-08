<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->orderBy('username')
            ->paginate(15);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = DB::table('user_roles')->orderBy('role_name')->get();

        return view('users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', 'exists:user_roles,id'],
        ]);

        User::query()->create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role_id' => $validated['role_id'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function disable(User $user)
    {
        if (! $user->is_active) {
            return redirect()
                ->route('users.index')
                ->with('success', 'User is already disabled.');
        }

        $user->is_active = false;
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User disabled successfully.');
    }
}
