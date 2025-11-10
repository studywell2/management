@extends('layouts.dash')

@section('title', 'Student Dashboard')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-primary mb-4">
        Welcome, {{ $student->name }}
    </h2>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-success text-white">
            <i class="bi bi-journal"></i> Your Results
        </div>
        <div class="card-body p-0">
            @if($results->count())
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Subject</th>
                            <th>Score</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $result->subject }}</td>
                                <td>{{ $result->score }}</td>
                                <td>{{ $result->grade }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center py-4 text-muted mb-0">
                    No results available yet.
                </p>
            @endif
        </div>
    </div>

    <form action="{{ route('student.logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>
@endsection
