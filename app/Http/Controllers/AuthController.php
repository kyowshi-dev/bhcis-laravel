<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the Login Form
    public function showLogin()
    {
        // If user is already logged in, send them to the dashboard (or patients list)
        if (Auth::check()) {
            return redirect()->route('patients.index');
        }

        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        // 1. Validate the Input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Attempt to Log In
        // specific 'remember' logic handles the checkbox
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            
            // 3. Security: Regenerate Session ID
            // (Prevents session fixation attacks)
            $request->session()->regenerate();

            // 4. Redirect User
            // 'intended' sends them to the URL they tried to visit before being intercepted by login
            // Default fallback is 'patients.index'
            return redirect()->intended(route('patients.index'));
        }

        // 5. If Login Fails...
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }
}