<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>School Results Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        h2, h4 {
            margin: 0;
        }
        .header {
            text-align: center;
        }
        .school-info {
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>{{ Auth::user()->school->school_name ?? 'School Name' }}</h2>
        <h4>Results Sheet</h4>
    </div>

    <div class="school-info">
        <p><strong>Address:</strong> {{ Auth::user()->school->address ?? '-' }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->school->email ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ Auth::user()->school->phone ?? '-' }}</p>
        <p><strong>Website:</strong> {{ Auth::user()->school->website ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Score</th>
                <th>Grade</th>
                <th>Term</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result->student_name }}</td>
                    <td>{{ $result->subject }}</td>
                    <td>{{ $result->score }}</td>
                    <td>{{ $result->grade }}</td>
                    <td>{{ $result->term }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
