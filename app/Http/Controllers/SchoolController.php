<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    // Show the school creation form
    public function create()
    {
        $school = auth()->user()->school ?? null;
        return view('school.create', compact('school'));
    }

    // Store or update school info
    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $school = auth()->user()->school;

        // Handle logo upload if file exists
        $logoPath = $school?->logo ?? null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        if ($school) {
            // Update existing school
            $school->update([
                'school_name' => $request->school_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'website' => $request->website,
                'logo' => $logoPath,
            ]);
        } else {
            // Create new school
            School::create([
                'user_id' => auth()->id(),
                'school_name' => $request->school_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'website' => $request->website,
                'logo' => $logoPath,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'School information saved successfully.');
    }
}
