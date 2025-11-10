@extends('layouts.app')

@section('title', 'Students List')

@section('content')
<div class="container py-5">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-people-fill"></i> Students
        </h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-person-plus"></i> Add Student
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-3">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Students Table --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Class</th>
                                <th>School</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $student->name }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->schoolClass ? $student->schoolClass->name : '—' }}</td>
                                    <td>{{ $student->school ? $student->school->school_name : '—' }}</td>
                                    <td>
                                        <a href="{{ route('students.edit', $student->id) }}" 
                                           class="btn btn-sm btn-warning shadow-sm me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('students.destroy', $student->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="return confirm('Are you sure you want to delete this student?')"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown display-4 text-muted"></i>
                    <p class="fs-5 mt-3 text-secondary mb-4">
                        No students found for your school yet.
                    </p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bi bi-person-plus"></i> Add Student
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Footer Navigation --}}
    <div class="mt-4 text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

</div>
@endsection
