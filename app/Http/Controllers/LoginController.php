<?php

namespace App\Http\Controllers;

use Auth;
use Closure;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            if ($user->role->name === 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === 'Doctor') {
                return redirect()->route('doctor.dashboard');
            } elseif ($user->role->name === 'Patient') {
                return redirect()->route('patient.dashboard');
            }

            // Fallback redirect
            return redirect()->route('loginPage');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginPage');
    }
}
