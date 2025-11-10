@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Class - {{ $class->name }}</h2>

    <form action="{{ route('classes.update', $class->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Class Name</label>
            <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
        </div>
        <div class="mb-3">
            <label for="section" class="form-label">Section</label>
            <input type="text" name="section" class="form-control" value="{{ $class->section }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Class</button>
    </form>
</div>
@endsection
