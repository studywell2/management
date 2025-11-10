@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Class</h2>

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Class Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="section" class="form-label">Section</label>
            <input type="text" name="section" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Save Class</button>
    </form>
</div>
@endsection
