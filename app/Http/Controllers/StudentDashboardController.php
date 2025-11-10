<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $results = $student->results()->latest()->get();

        return view('student.dashboard', compact('student', 'results'));
    }
}
