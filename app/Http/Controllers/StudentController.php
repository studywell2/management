<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Added this

class StudentController extends Controller
{
    /**
     * Show all students (with payment check for student users)
     */
   public function index()
{
    $user = auth()->user();
    $school = $user->school;

    if (!$school) {
        return redirect()->back()->with('error', 'Please register your school first.');
    }

    // Fetch all students belonging to this school
    $students = $school->students()->with('schoolClass')->get();

    // Optional: Payment check for student users
    if ($user->role === 'student' && !$user->student->paid_term_fee) {
        return redirect()->route('payment.form')->with('error', 'Please pay your term fee to continue.');
    }

    return view('students.index', compact('students'));
}

    /**
     * Show form to create a new student
     */
    public function create()
    {
        $school = auth()->user()->school;

        if (!$school) {
            return redirect()->back()->with('error', 'Please register your school first.');
        }

        $classes = $school->classes()->get();

        return view('students.create', compact('classes'));
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        $school = auth()->user()->school;

        if (!$school) {
            return redirect()->back()->with('error', 'Please register your school first.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|unique:students,student_id',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        Student::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'school_id' => $school->id,
            'school_class_id' => $request->school_class_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Edit an existing student
     */
    public function edit(Student $student)
    {
        $school = auth()->user()->school;

        if (!$school) {
            return redirect()->back()->with('error', 'Please register your school first.');
        }

        $classes = $school->classes()->get();

        return view('students.edit', compact('student', 'classes'));
    }

    /**
     * Update a student record
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $student->update([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'school_class_id' => $request->school_class_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Delete a student
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    /**
     * Show student dashboard
     */
    public function dashboard()
    {
        $student = auth()->guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login')->with('error', 'Please log in first.');
        }

        $results = $student->results ?? collect();

        return view('student.dash', compact('student', 'results'));
    }

    /**
     * Logout the student
     */
    public function logout(Request $request)
    {
        auth()->guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}
