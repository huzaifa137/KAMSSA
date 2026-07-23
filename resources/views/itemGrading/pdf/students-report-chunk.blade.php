<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Students Report - Page {{ $chunk_number }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 9px; 
            margin: 0.5cm;
        }
        .header-info {
            text-align: right;
            font-size: 8px;
            color: #666;
            margin-bottom: 10px;
            border-bottom: 1px solid #287C44;
            padding-bottom: 5px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th { 
            background-color: #287C44; 
            color: white; 
            padding: 6px; 
            font-size: 9px;
            text-align: center;
            font-weight: bold;
        }
        td { 
            border: 1px solid #ddd; 
            padding: 4px; 
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .page-footer {
            text-align: center;
            font-size: 7px;
            color: #999;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px dotted #ccc;
        }
        .student-id {
            font-family: monospace;
            font-size: 8px;
        }
        .school-name {
            text-align: left;
            padding-left: 5px;
        }
    </style>
</head>
<body>
    <div class="header-info">
        Page {{ $chunk_number }} of {{ $total_chunks }} | 
        Showing records {{ $start_index }} - {{ $end_index }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%">Student ID</th>
                <th width="30%">School</th>
                <th width="8%">Gender</th>
                <th width="12%">Marks</th>
                <th width="12%">%</th>
                <th width="13%">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $start_index + $index }}</td>
                <td class="student-id">{{ $student['student_id'] }}</td>
                <td class="school-name">{{ $student['school_name'] }}</td>
                <td>{{ $student['gender'] == 'male' ? 'M' : 'F' }}</td>
                <td>{{ number_format($student['total_marks'], 1) }}</td>
                <td>{{ number_format($student['percentage'], 1) }}%</td>
                <td>
                    @php
                        $gradeClass = match($student['grade']) {
                            'D1' => 'D1',
                            'D2' => 'D2',
                            'C3' => 'C3',
                            'C4' => 'C4',
                            default => 'F'
                        };
                    @endphp
                    <span style="
                        display: inline-block;
                        padding: 2px 6px;
                        border-radius: 3px;
                        background-color: 
                            {{ $gradeClass == 'D1' ? '#fbbf24' : 
                               ($gradeClass == 'D2' ? '#a7f3d0' : 
                               ($gradeClass == 'C3' ? '#bfdbfe' : 
                               ($gradeClass == 'C4' ? '#fed7aa' : '#fee2e2'))) }};
                        color: 
                            {{ $gradeClass == 'D1' ? '#92400e' : 
                               ($gradeClass == 'D2' ? '#065f46' : 
                               ($gradeClass == 'C3' ? '#1e40af' : 
                               ($gradeClass == 'C4' ? '#9a3412' : '#b91c1c'))) }};
                        font-weight: bold;
                    ">
                        {{ $student['grade'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="page-footer">
        Page {{ $chunk_number }} of {{ $total_chunks }} | 
        Generated: {{ now()->format('Y-m-d H:i:s') }}
    </div>
</body>
</html>