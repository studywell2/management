<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherAttendance;

class TeacherController extends Controller
{
    // ===========================
    // SHOW ALL TEACHERS
    // ===========================
    public function index()
    {
        $user = auth()->user();
        $school = $user->school;

        if (!$school) {
            return redirect()->back()->with('error', 'Please register your school first.');
        }

        // Restrict unpaid teachers
        if ($user->role === 'teacher' && !$user->teacher->paid_allowance) {
            return redirect()->route('payment.form')->with('error', 'Please pay your allowance to continue.');
        }

        // Load teachers from school
        $teachers = $school->teachers()->get();

        return view('teachers.index', compact('teachers'));
    }


    // ===========================
    // SHOW CREATE FORM
    // ===========================
    public function create()
    {
        return view('teachers.create');
    }


    // ===========================
    // STORE NEW TEACHER
    // ===========================
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:teachers,email',
            'subject'=> 'nullable|string|max:255',
            'phone'  => 'nullable|string|max:20',
        ]);

        $school = auth()->user()->school;

        Teacher::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'subject'   => $request->subject,
            'phone'     => $request->phone,
            'school_id' => $school->id,  // IMPORTANT
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }


    // ===========================
    // EDIT TEACHER
    // ===========================
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }


    // ===========================
    // UPDATE TEACHER
    // ===========================
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:teachers,email,' . $teacher->id,
            'subject'=> 'nullable|string|max:255',
            'phone'  => 'nullable|string|max:20',
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }


    // ===========================
    // DELETE TEACHER
    // ===========================
    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }


    // ===========================
    // TEACHER ATTENDANCE FORM
    // ===========================
    public function attendanceForm($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        $attendance = TeacherAttendance::where('teacher_id', $teacherId)
            ->where('date', now()->toDateString())
            ->first();

        return view('teachers.attendance', compact('teacher', 'attendance'));
    }


    // ===========================
    // SAVE OR UPDATE ATTENDANCE
    // ===========================
    public function attendance(Request $request, $teacherId)
    {
        $request->validate([
            'sign_in'  => 'nullable|date_format:H:i',
            'sign_out' => 'nullable|date_format:H:i|after_or_equal:sign_in',
        ]);

        TeacherAttendance::updateOrCreate(
            [
                'teacher_id' => $teacherId,
                'date'       => now()->toDateString(),
            ],
            [
                'sign_in'  => $request->sign_in,
                'sign_out' => $request->sign_out,
            ]
        );

        return redirect()->back()->with('success', 'Attendance updated successfully.');
    }
}
