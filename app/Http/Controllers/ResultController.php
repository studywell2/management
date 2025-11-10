<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display all results grouped by student.
     */
    public function index()
{
    $school = auth()->user()->school;

    // Fetch results for the logged-in school, with relationships
    $results = Result::with(['student.schoolClass', 'subject'])
        ->where('school_id', $school->id)
        ->get();

    // Group results by student_id
    $resultsGrouped = $results->groupBy('student_id');

    return view('results.index', compact('resultsGrouped'));
}

    /**
     * Show create form.
     */
    public function create()
    {
        $students = Student::with('schoolClass')->get();
        return view('results.create', compact('students'));
    }

    /**
     * Store a new result for multiple subjects.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subjects'   => 'required|array',
            'scores'     => 'required|array',
            'terms'      => 'required|array',
            'sessions'   => 'required|array',
        ]);

        $school = auth()->user()->school;
        if (!$school) {
            return back()->with('error', 'No school found for this user.');
        }

        $student = Student::with('schoolClass')->findOrFail($request->student_id);

        foreach ($request->subjects as $index => $subjectName) {
            $subject = Subject::firstOrCreate([
                'name'      => $subjectName,
                'school_id' => $school->id,
            ]);

            Result::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'term'       => $request->terms[$index],
                    'session'    => $request->sessions[$index],
                ],
                [
                    'school_id'    => $school->id,
                    'student_name' => $student->name,
                    'score'        => $request->scores[$index],
                    'grade'        => $this->calculateGrade($request->scores[$index]),
                ]
            );
        }

        return redirect()->route('results.index')->with('success', 'Results saved successfully.');
    }

    /**
     * Edit a single result.
     */
    public function edit($id)
    {
        $result = Result::with(['student.schoolClass', 'subject'])->findOrFail($id);
        return view('results.edit', compact('result'));
    }

    /**
     * Update a single result.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'score'   => 'required|numeric|min:0|max:100',
            'term'    => 'required|string|max:255',
            'session' => 'required|string|max:10',
        ]);

        $result = Result::findOrFail($id);
        $school = auth()->user()->school;

        $subject = Subject::firstOrCreate([
            'name'      => $request->subject,
            'school_id' => $school->id,
        ]);

        $result->update([
            'subject_id' => $subject->id,
            'score'      => $request->score,
            'grade'      => $this->calculateGrade($request->score),
            'term'       => $request->term,
            'session'    => $request->session,
        ]);

        return redirect()->route('results.index')->with('success', 'Result updated successfully.');
    }

    /**
     * Delete a result.
     */
    public function destroy($id)
    {
        Result::findOrFail($id)->delete();
        return redirect()->route('results.index')->with('success', 'Result deleted successfully.');
    }

    /**
     * Export results as Excel.
     */
    public function export()
    {
        $results = Result::with(['student.schoolClass', 'subject'])->get();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=results.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>
                <tr>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Term</th>
                    <th>Session</th>
                    <th>Grade</th>
                </tr>";

        foreach ($results as $r) {
            echo "<tr>
                    <td>{$r->student_name}</td>
                    <td>{$r->student_id}</td>
                    <td>" . ($r->student->schoolClass->name ?? 'N/A') . "</td>
                    <td>{$r->subject->name}</td>
                    <td>{$r->score}</td>
                    <td>{$r->term}</td>
                    <td>{$r->session}</td>
                    <td>{$r->grade}</td>
                  </tr>";
        }

        echo "</table>";
        exit;
    }

    /**
     * Print all results grouped by student.
     */
    public function printAll()
{
    $school = auth()->user()->school;

    // Fetch all results for this school
    $results = Result::with(['student.schoolClass', 'subject'])
        ->where('school_id', $school->id)
        ->get();

    $groupedResults = $results->groupBy([
        fn($result) => $result->student->schoolClass->name ?? 'Unknown Class',
        fn($result) => $result->term ?? 'Unknown Term',
        fn($result) => $result->session ?? 'Unknown Session',
    ]);

    // Pass the school to the view
    return view('results.print-all', [
        'results' => $groupedResults,
        'school'  => $school
    ]);
}

    /**
     * Print a single student’s results.
     */
   public function printStudent($student_id)
{
    $student = Student::with('schoolClass')->findOrFail($student_id);
    $school = auth()->user()->school; // <-- add this

    $studentResults = Result::with('subject')
        ->where('student_id', $student_id)
        ->orderBy('created_at', 'desc')
        ->get();

    $studentName  = $student->name;
    $studentClass = $student->schoolClass->name ?? 'N/A';

    return view('results.print-student', compact(
        'studentResults',
        'studentName',
        'studentClass',
        'school' // <-- pass school to view
    ));
}

    private function calculateGrade($score)
    {
        if ($score >= 70) return 'A';
        if ($score >= 60) return 'B';
        if ($score >= 50) return 'C';
        if ($score >= 45) return 'D';
        if ($score >= 40) return 'E';
        return 'F';
    }
}
