@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">{{ $school ? 'Edit School' : 'Add School' }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('school.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">School Name</label>
            <input type="text" name="school_name" class="form-control" value="{{ old('school_name', $school->school_name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $school->address ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $school->email ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $school->phone ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="url" name="website" class="form-control" value="{{ old('website', $school->website ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" name="logo" class="form-control">
            @if(!empty($school?->logo))
                <img src="{{ asset('storage/' . $school->logo) }}" alt="School Logo" class="mt-2" style="max-height: 100px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ $school ? 'Update' : 'Save' }}</button>
    </form>
</div>
@endsection
