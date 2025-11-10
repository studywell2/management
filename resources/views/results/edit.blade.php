<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4 text-center">Edit Result</h2>

        <form method="POST" action="{{ route('results.update', $result->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Student Name</label>
                <input type="text" name="student_name" value="{{ $result->student_name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Student ID</label>
                <input type="text" name="student_id" value="{{ $result->student_id }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Class</label>
                <input type="text" name="class" value="{{ $result->class }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" value="{{ $result->subject }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Score</label>
                <input type="number" name="score" value="{{ $result->score }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Term</label>
                <select name="term" class="form-select" required>
                    <option value="First Term" {{ $result->term == 'First Term' ? 'selected' : '' }}>First Term</option>
                    <option value="Second Term" {{ $result->term == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                    <option value="Third Term" {{ $result->term == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Session</label>
                <input type="number" name="session" value="{{ $result->session }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Result</button>
        </form>
    </div>
</body>
</html>
