@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
<div class="container py-5">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center fs-4 fw-bold py-3">
            <i class="bi bi-person-plus"></i> Add New Student
        </div>

        <div class="card-body p-4">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded-3">
                    <i class="bi bi-exclamation-circle-fill"></i> 
                    <strong> Please fix the following:</strong>
                    <ul class="mt-2 mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                {{-- Full Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" 
                           name="name" 
                           class="form-control form-control-lg shadow-sm" 
                           value="{{ old('name') }}" 
                           placeholder="Enter full name" 
                           required>
                </div>

                {{-- Student ID --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Student ID</label>
                    <input type="text" 
                           name="student_id" 
                           class="form-control form-control-lg shadow-sm" 
                           value="{{ old('student_id') }}" 
                           placeholder="e.g. STU-001" 
                           required>
                </div>

                {{-- Class Dropdown --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Select Class</label>
                    <select name="school_class_id" class="form-select form-select-lg shadow-sm" required>
                        <option value="">-- Select Class --</option>
                        @forelse($classes as $class)
                            <option value="{{ $class->id }}" 
                                {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} {{ $class->section ?? '' }}
                            </option>
                        @empty
                            <option disabled>No classes created yet</option>
                        @endforelse
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bi bi-arrow-left-circle"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                        <i class="bi bi-save"></i> Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Return to Dashboard --}}
    <div class="mt-4 text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
            <i class="bi bi-speedometer2"></i> Back to Dashboard
        </a>
    </div>
</div>
@endsection
