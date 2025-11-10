<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Results - Print</title>
  <style>
    /* General Styles */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 20px;
      color: #333;
    }

    h1, h2, h3 {
      margin: 0 0 10px 0;
      font-weight: 600;
    }

    h1 {
      text-align: center;
      color: #0d6efd;
      margin-bottom: 30px;
    }

    h2 {
      background-color: #e9f2ff;
      padding: 8px 12px;
      border-left: 5px solid #0d6efd;
      margin-top: 30px;
    }

    h3 {
      font-size: 1rem;
      color: #555;
      margin-top: 15px;
      margin-bottom: 8px;
    }

    /* Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px 10px;
      text-align: center;
      font-size: 0.95rem;
    }

    th {
      background-color: #0d6efd;
      color: #fff;
      font-weight: 600;
    }

    tbody tr:nth-child(even) {
      background-color: #f7f9fc;
    }

    /* Buttons */
    .no-print {
      margin-bottom: 20px;
    }

    .no-print button, .no-print a {
      padding: 6px 12px;
      font-size: 0.9rem;
      margin-right: 10px;
      border-radius: 5px;
      text-decoration: none;
      border: none;
      cursor: pointer;
    }

    .no-print button {
      background-color: #0d6efd;
      color: #fff;
    }

    .no-print a {
      background-color: #6c757d;
      color: #fff;
    }

    /* Page Breaks for Printing */
    @media print {
      .no-print {
        display: none;
      }
      h2 {
        page-break-before: always;
      }
      table {
        page-break-inside: avoid;
      }
    }

  </style>
</head>
<body>

  <h1>All Student Results</h1>

  <div class="no-print">
      <button onclick="window.print()">🖨️ Print This Page</button>
      <a href="{{ route('results.index') }}">⬅ Back to Results</a>
  </div>


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

  @foreach ($results as $class => $terms)
      <h2>Class: {{ $class }}</h2>
      @foreach ($terms as $term => $sessions)
          @foreach ($sessions as $session => $resultsInGroup)
              <h3>Term: {{ $term }} | Session: {{ $session }}</h3>
              <table>
                  <thead>
                      <tr>
                          <th>Student Name</th>
                          <th>Student ID</th>
                          <th>Subject</th>
                          <th>Score</th>
                          <th>Grade</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($resultsInGroup as $result)
                      <tr>
                          <td>{{ $result->student_name }}</td>
                          <td>{{ $result->student_id }}</td>
                          <td>{{ $result->subject->name ?? 'N/A' }}</td> {{-- ✅ Fixed --}}
                          <td>{{ $result->score }}</td>
                          <td>{{ $result->grade }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          @endforeach
      @endforeach
  @endforeach

</body>
</html>
