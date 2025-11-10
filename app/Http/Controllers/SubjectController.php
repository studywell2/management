<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ✅ Detect school or teacher role
        if ($user->role === 'school') {
            $school = $user->school;

            // 🚫 Block unpaid school
            if (!$school || !$school->paid_term_fee) {
                return redirect()->route('payment.form')
                    ->with('error', 'Please complete your term fee payment to access subjects.');
            }

            $subjects = Subject::with('teacher')->where('school_id', $school->id)->get();
            return view('subjects.index', compact('subjects', 'school'));
        }

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;

            // 🚫 Block unpaid teacher
            if (!$teacher || !$teacher->paid_allowance) {
                return redirect()->route('payment.form')
                    ->with('error', 'Please complete your allowance payment to access subjects.');
            }

            $subjects = Subject::where('teacher_id', $teacher->id)->get();
            return view('subjects.index', compact('subjects'));
        }

        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('subjects.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $school = Auth::guard('school')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        Subject::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'school_id' => $school->id,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $teachers = Teacher::all();
        return view('subjects.edit', compact('subject', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $school = Auth::guard('school')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $subject->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'school_id' => $school->id,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
