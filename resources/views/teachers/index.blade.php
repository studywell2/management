@extends('layouts.app')

@section('content')
<h1>Teachers</h1>
<a href="{{ route('teachers.create') }}" class="btn btn-primary">Add Teacher</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->subject }}</td>
                <td>{{ $teacher->phone }}</td>
                <td>
                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('teachers.attendance.form', $teacher->id) }}" class="btn btn-sm btn-info">Attendance</a>
                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this teacher?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
