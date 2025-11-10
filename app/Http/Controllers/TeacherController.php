<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherAttendance;


class TeacherController extends Controller
{
    // Display all teachers
  public function index()
{
    $user = auth()->user();
    $school = $user->school;

    if (!$school) {
        return redirect()->back()->with('error', 'Please register your school first.');
    }

    // Payment restriction
    if ($user->role === 'teacher' && !$user->teacher->paid_allowance) {
        return redirect()->route('payment.form')->with('error', 'Please pay your allowance to continue.');
    }

    // Fetch teachers for the school
    $teachers = $school->teachers()->get();

    return view('teachers.index', compact('teachers'));
}

    // Show form to create a teacher
    public function create()
    {
        return view('teachers.create');
    }

    // Store teacher
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Teacher::create($request->all());

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    // Edit teacher
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }

    // Update teacher
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    // Delete teacher
    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    // Teacher Attendance Form
    public function attendanceForm($teacherId)
{
    $teacher = Teacher::findOrFail($teacherId);

    // Get today's attendance, not the latest one
    $attendance = TeacherAttendance::where('teacher_id', $teacherId)
        ->where('date', now()->toDateString())
        ->first();

    return view('teachers.attendance', compact('teacher', 'attendance'));
}

    // Store or update attendance
    public function attendance(Request $request, $teacherId)
{
    $request->validate([
        'sign_in' => 'nullable|date_format:H:i',
        'sign_out' => 'nullable|date_format:H:i|after_or_equal:sign_in',
    ]);

    TeacherAttendance::updateOrCreate(
        [
            'teacher_id' => $teacherId,
            'date' => now()->toDateString()
        ],
        [
            'sign_in' => $request->sign_in,
            'sign_out' => $request->sign_out,
        ]
    );

    return redirect()->back()->with('success', 'Attendance updated successfully.');
}

}