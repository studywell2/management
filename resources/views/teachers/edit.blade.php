@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Teachers</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Teacher</li>
        </ol>
    </nav>

    <h2 class="mb-4">Edit Teacher - {{ $teacher->name }}</h2>

    {{-- Flash & Errors --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject', $teacher->subject) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}">
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Update Teacher</button>
        </div>
    </form>
</div>
@endsection
