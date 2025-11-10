@extends('layouts.app')

@section('title', 'Add Result')

@section('content')
<div class="card shadow-sm p-4">
    <h2 class="mb-4 text-primary"><i class="bi bi-journal-plus"></i> Add Result</h2>

    <form action="{{ route('results.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_id }})</option>
                @endforeach
            </select>
        </div>

        <div id="subjects-wrapper">
            <div class="subject-row row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subjects[]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Score</label>
                    <input type="number" name="scores[]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Term</label>
                    <input type="text" name="terms[]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Session</label>
                    <input type="text" name="sessions[]" class="form-control" required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-subject">Remove</button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-secondary" id="add-subject">+ Add Another Subject</button>
        </div>

        <button type="submit" class="btn btn-primary">Save Results</button>
        <a href="{{ route('results.index') }}" class="btn btn-outline-secondary">Back</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('subjects-wrapper');
    const addBtn = document.getElementById('add-subject');

    addBtn.addEventListener('click', () => {
        const newRow = wrapper.querySelector('.subject-row').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        wrapper.appendChild(newRow);
    });

    wrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-subject')) {
            const rows = wrapper.querySelectorAll('.subject-row');
            if (rows.length > 1) e.target.closest('.subject-row').remove();
        }
    });
});
</script>
@endsection
