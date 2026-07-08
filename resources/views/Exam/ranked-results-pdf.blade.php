<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Class Ranking</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Class Ranking Report</h2>
    <p><strong>Class:</strong> {{ $className }}</p>
    <p><strong>Exam:</strong> {{ $examName }}</p>
    <p><strong>School Year:</strong> {{ $year }}</p>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Student Name</th>
                <th>Total Marks</th>
                <th>Average (%)</th>
                <th>Grade</th>
                <th>Stream</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rankedStudents as $student)
                <tr>
                    <td>{{ $student->rank }}</td>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->total_marks }}</td>
                    <td>{{ $student->average }}</td>
                    <td>{{ $student->grade }}</td>
                    <td>{{ $student->stream_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>