<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('username')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:50',
        ]);

        session([
            'username' => $request->username,
            'last_activity' => time()
        ]);

        return redirect()->route('dashboard')->with('success', 'Welcome, ' . $request->username . '!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function checkSession(Request $request)
    {
        if (!session()->has('username')) {
            return response()->json(['active' => false], 401);
        }

        session(['last_activity' => time()]);

        return response()->json([
            'active' => true,
            'username' => session('username')
        ]);
    }
}
