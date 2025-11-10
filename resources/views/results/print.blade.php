<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $student->name ?? 'Student' }} - Result Report</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
    h1, h2, h3 { margin-bottom: 10px; text-align: center; }
    h1 { color: #0d6efd; margin-bottom: 10px; }
    h2 { font-size: 1.2rem; color: #333; margin-bottom: 5px; }
    h3 { font-size: 1rem; color: #555; margin-bottom: 30px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    th, td { border: 1px solid #333; padding: 8px; text-align: center; }
    th { background-color: #0d6efd; color: #fff; }
    tbody tr:nth-child(even) { background-color: #f7f7f7; }
    .no-print { margin-bottom: 20px; }
    .no-print button, .no-print a {
      padding: 6px 12px; font-size: 0.9rem; margin-right: 10px; border-radius: 5px;
      text-decoration: none; border: none; cursor: pointer;
    }
    .no-print button { background-color: #0d6efd; color: #fff; }
    .no-print a { background-color: #6c757d; color: #fff; }
    @media print {
      .no-print { display: none; }
      table { page-break-inside: avoid; }
    }
  </style>
</head>
<body>

  {{-- ✅ School Info --}}
  <h1>{{ $schoolName ?? 'School Name' }}</h1>
  <h2>Student Result Report</h2>
  <h3>{{ $studentName }} ({{ $studentClass }})</h3>
  <p style="text-align:center;">
    <strong>Term:</strong> {{ $term }} |
    <strong>Session:</strong> {{ $session }}
  </p>

  <div class="no-print" style="text-align:center;">
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
