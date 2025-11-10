@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Classes</h2>

    <a href="{{ route('classes.create') }}" class="btn btn-success mb-3">Add New Class</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Section</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
            <tr>
                <td>{{ $class->id }}</td>
                <td>{{ $class->name }}</td>
                <td>{{ $class->section }}</td>
                <td>{{ $class->students->count() }}</td>
                <td>
                    <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this class?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
