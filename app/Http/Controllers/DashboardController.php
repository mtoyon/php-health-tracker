<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('username')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $username = session('username');

        return view('dashboard', compact('username'));
    }
}
