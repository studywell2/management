@extends('layouts.app')

@section('title', 'Edit Subject')

@section('content')
<div class="container py-5">

    {{-- SCHOOL NAME HEADER --}}
    <div class="text-center mb-4">
        <h1 class="fw-bold text-uppercase text-primary">
            {{ Auth::guard('school')->user()->name ?? 'Your School Name' }}
        </h1>
        <p class="text-muted mb-0">Edit Subject Details</p>
        <hr class="w-50 mx-auto">
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-dark text-center fs-4 fw-bold py-3">
            <i class="bi bi-pencil-square"></i> Edit Subject
        </div>

        <div class="card-body p-4">
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

            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject Name</label>
                    <input type="text" name="name" class="form-control form-control-lg shadow-sm" 
                           value="{{ old('name', $subject->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Assign Teacher</label>
                    <select name="teacher_id" class="form-select form-select-lg shadow-sm">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bi bi-arrow-left-circle"></i> Back
                    </a>
                    <button type="submit" class="btn btn-warning btn-lg text-white px-4 shadow-sm">
                        <i class="bi bi-save"></i> Update Subject
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
