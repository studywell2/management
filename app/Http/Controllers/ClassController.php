<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass; // Class model
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Display all classes
    public function index()
    {
        $classes = SchoolClass::with('students')->get();
        return view('classes.index', compact('classes'));
    }

    // Show form to create class
    public function create()
    {
        return view('classes.create');
    }

    // Store class
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'section' => 'nullable|string|max:50',
    ]);

    $school = auth()->user()->school; // get the logged-in user's school

    SchoolClass::create([
        'name' => $request->name,
        'section' => $request->section,
        'school_id' => $school->id, // <-- important
    ]);

    return redirect()->route('classes.index')->with('success', 'Class added successfully.');
}


    // Edit class
    public function edit($id)
    {
        $class = SchoolClass::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    // Update class
    public function update(Request $request, $id)
    {
        $class = SchoolClass::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    // Delete class
    public function destroy($id)
    {
        SchoolClass::findOrFail($id)->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
