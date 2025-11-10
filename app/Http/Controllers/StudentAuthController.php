<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('studentss.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'student_id' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('student')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'student_id' => 'Invalid student ID or password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/student/login');
    }
}
