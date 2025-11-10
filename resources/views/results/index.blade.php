@extends('layouts.app')

@section('title', 'All Results')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="fw-bold text-primary mb-0">
        <i class="bi bi-journal-check"></i> All Results
    </h2>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('results.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Result
        </a>
        <a href="{{ route('results.export') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export
        </a>
        <a href="{{ route('results.printAll') }}" class="btn btn-secondary" target="_blank">
            🖨️ Print All
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow border-0 rounded-4">
    <div class="card-header bg-primary text-white fw-bold">
        <i class="bi bi-table"></i> Student Results
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Class</th>
                        <th>Subjects & Scores</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($resultsGrouped as $student_id => $studentResults)
                        @php $firstResult = $studentResults->first(); @endphp
                        <tr>
                            <td>{{ $firstResult->student_name }}</td>
                            <td>{{ $firstResult->student_id }}</td>

                            {{-- ✅ Display class correctly (priority: schoolClass → student.class → result.class) --}}
                            <td>
                                {{ $firstResult->student->schoolClass->name 
                                    ?? $firstResult->student->class 
                                    ?? $firstResult->class 
                                    ?? 'N/A' }}
                            </td>

                            <td>
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Score</th>
                                            <th>Term</th>
                                            <th>Session</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentResults as $result)
                                        <tr>
                                            <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                            <td>{{ $result->score }}</td>
                                            <td>{{ $result->term }}</td>
                                            <td>{{ $result->session }}</td>
                                            <td>{{ $result->grade }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>

                            <td>
                                <a href="{{ route('results.printStudent', $firstResult->student_id) }}" 
                                   class="btn btn-sm btn-outline-secondary mb-1" target="_blank">
                                    🖨️ Print Student
                                </a>
                                <a href="{{ route('results.edit', $firstResult->id) }}" 
                                   class="btn btn-sm btn-outline-primary mb-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('results.destroy', $firstResult->id) }}" 
                                      method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger mb-1"
                                            onclick="return confirm('Are you sure you want to delete this result?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-emoji-frown"></i> No results available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
