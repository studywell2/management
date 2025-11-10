@extends('layouts.app')

@section('title', 'Edit Student Details')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-warning text-dark text-center fs-4 fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Student Details
        </div>

        <div class="card-body p-4">
            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Full Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control form-control-lg" 
                           value="{{ $student->name }}" required>
                </div>

                {{-- Student ID --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Student ID</label>
                    <input type="text" name="student_id" class="form-control form-control-lg" 
                           value="{{ $student->student_id }}" required>
                </div>

                {{-- Class --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Select Class</label>
                    <select name="school_class_id" class="form-select form-control-lg shadow-sm" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" 
                                {{ $student->school_class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} {{ $class->section ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left-circle"></i> Back
                    </a>
                    <button type="submit" class="btn btn-warning btn-lg text-white px-4">
                        <i class="bi bi-save"></i> Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
