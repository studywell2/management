<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $student->name ?? 'Student' }} - Result Report</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
    h1, h2 { margin-bottom: 10px; }
    h1 { text-align: center; color: #0d6efd; margin-bottom: 30px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    th, td { border: 1px solid #333; padding: 8px; text-align: center; }
    th { background-color: #0d6efd; color: #fff; }
    tbody tr:nth-child(even) { background-color: #f7f7f7; }
    .no-print { margin-bottom: 20px; }
    .no-print button, .no-print a {
      padding: 6px 12px; font-size: 0.9rem; margin-right: 10px; border-radius: 5px; text-decoration: none; border: none; cursor: pointer;
    }
    .no-print button { background-color: #0d6efd; color: #fff; }
    .no-print a { background-color: #6c757d; color: #fff; }
    @media print { .no-print { display: none; } table { page-break-inside: avoid; } }
  </style>
</head>
<body>
@if($school)
<div class="text-center mb-4">
    <h2>{{ $school->school_name }}</h2>
    <p>
        {{ $school->address }} <br>
        Email: {{ $school->email }} | Phone: {{ $school->phone }} <br>
        Website: {{ $school->website }}
    </p>

    @if($school->logo)
        <img src="{{ asset('storage/' . $school->logo) }}" alt="School Logo" width="100">
    @endif
</div>
@endif

  <h1>{{ $studentName }} ({{ $studentClass }}) - Result Report</h1>
  <p><strong>Class:</strong> {{ $studentClass }}</p>

  <div class="no-print">
      <button onclick="window.print()">🖨️ Print Report</button>
      <a href="{{ route('results.index') }}">⬅ Back to Results</a>
  </div>

  <table>
      <thead>
          <tr>
              <th>Subject</th>
              <th>Score</th>
              <th>Grade</th>
              <th>Term</th>
              <th>Session</th>
          </tr>
      </thead>
      <tbody>
          @foreach($studentResults as $result)
          <tr>
              <td>{{ $result->subject->name ?? 'N/A' }}</td>
              <td>{{ $result->score }}</td>
              <td>{{ $result->grade }}</td>
              <td>{{ $result->term }}</td>
              <td>{{ $result->session }}</td>
          </tr>
          @endforeach
      </tbody>
  </table>

</body>
</html>
