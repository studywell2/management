@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Attendance - {{ $teacher->name }}</h2>
        <p class="text-muted">Update sign in/out times and view current attendance</p>
    </div>

    <div class="row justify-content-center">
        <!-- Attendance Form -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Update Attendance
                </div>
                <div class="card-body">
                    <form action="{{ route('teachers.attendance', $teacher->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="sign_in" class="form-label">Sign In</label>
                            <input type="time" class="form-control" name="sign_in"
                                value="{{ old('sign_in', $attendance->sign_in ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="sign_out" class="form-label">Sign Out</label>
                            <input type="time" class="form-control" name="sign_out"
                                value="{{ old('sign_out', $attendance->sign_out ?? '') }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Attendance</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Attendance -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    Current Attendance
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Sign In:</strong> {{ $attendance->sign_in ?? '--:-- --' }}</p>
                    <p class="mb-0"><strong>Sign Out:</strong> {{ $attendance->sign_out ?? '--:-- --' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
