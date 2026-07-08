<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Schools Performance Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header-container {
            border-bottom: 3px solid #c51619;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #c51619;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Keeps columns consistent */
        }

        /* The Fix: Fixed height for the header row */
        thead tr {
            height: 130px; 
        }

        th {
            background-color: #c51619;
            color: #ffffff;
            font-weight: bold;
            border: 1px solid #1e5e33;
            font-size: 10px;
            padding: 0; /* Clear padding to control rotation space */
            position: relative;
        }

        /* Centering the vertical text */
        .vertical-wrapper {
            position: relative;
            height: 130px; /* Must match the thead tr height */
            width: 100%;
        }

        .vertical-text {
            display: inline-block;
            white-space: nowrap;
            /* Rotation logic */
            transform: rotate(-90deg);
            transform-origin: center;
            
            /* Positioning logic to center it in the cell */
            position: absolute;
            bottom: 60px; /* Adjust this based on your text length */
            left: 50%;
            margin-left: -10px; /* Half of the line height to center it perfectly */
            width: 20px;
        }

        td {
            padding: 8px 4px;
            border: 1px solid #e0e0e0;
            text-align: center;
            vertical-align: middle;
        }

        .school-name-col {
            text-align: left;
            width: 25%;
            padding-left: 10px;
        }

        /* Visual styling */
        tbody tr:nth-child(even) {
            background-color: #f2f8f4;
        }

        .highlight-col {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #eee;
        }

        .page-number:before { content: "Page " counter(page); }
    </style>
</head>
<body>

    <div class="header-container">
        <h1 class="header-title">Schools Full Performance Report</h1>
        <p style="margin: 5px 0; color: #666;">
            Year: <strong>{{ $year }}</strong> | 
            Category: <strong>{{ $category }}</strong> | 
            Level: <strong>{{ $levelName }}</strong>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th class="school-name-col">School Name & Code</th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Total Student</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">First Class</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Second Upper</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Second Lower</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Third Class</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Fail</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Graded</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Average %</span></div></th>
                <th><div class="vertical-wrapper"><span class="vertical-text">Pass Rate</span></div></th>
            </tr>
        </thead>
        <tbody>
            @foreach($allSchools as $index => $school)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="school-name-col">
                    <strong>{{ $school['school_name'] }}</strong><br>
                    <small style="color: #888;">{{ $school['school_code'] }}</small>
                </td>
                <td>{{ $school['total_students'] }}</td>
                <td>{{ $school['grades']['FIRST CLASS'] }}</td>
                <td>{{ $school['grades']['SECOND CLASS UPPER'] }}</td>
                <td>{{ $school['grades']['SECOND CLASS LOWER'] }}</td>
                <td>{{ $school['grades']['THIRD CLASS'] }}</td>
                <td style="color: #d00;">{{ $school['grades']['FAIL'] }}</td>
                <td>{{ $school['graded_students'] }}</td>
                <td>{{ number_format($school['average_percentage'], 1) }}%</td>
                <td>{{ number_format($school['pass_rate'], 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ date('Y-m-d H:i') }} | <span class="page-number"></span>
    </div>

</body>
</html>