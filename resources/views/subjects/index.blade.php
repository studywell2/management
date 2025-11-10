@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Subjects Dashboard</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Subject Name</th>
                <th>Assigned Teacher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->teacher->name ?? 'Not Assigned' }}</td>
                    <td>
                        <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>

                        {{-- 💳 Payment Button --}}
                        @if(Auth::user()->role === 'school' && !Auth::user()->school->paid_term_fee)
                            <a href="{{ route('payment.form') }}" class="btn btn-sm btn-warning">Pay Now</a>
                        @elseif(Auth::user()->role === 'teacher' && !Auth::user()->teacher->paid_allowance)
                            <a href="{{ route('payment.form') }}" class="btn btn-sm btn-warning">Pay Allowance</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No subjects found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
