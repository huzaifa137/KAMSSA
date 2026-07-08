<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0; /* Control margins via the .report-card div */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .report-card {
            box-sizing: border-box; 
            width: 19cm; /* Fixed width prevents the right border from cutting off */
            margin: 1cm auto; /* Centers card on the A4 page */
            background: white;
            border: 5px solid #FFD700; 
            padding: 30px;
            page-break-after: always;
            position: relative;
            min-height: 27cm;
        }

        .header {
            text-align: center;
            color: #2E7D32;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 22px;
        }

        .motto {
            font-style: italic;
            font-weight: bold;
            margin: 15px 0;
            font-size: 16px;
        }

        .divider {
            border-top: 3px double #000;
            margin-bottom: 10px;
        }

        .title-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .title-box span {
            font-size: 24px;
            font-weight: bold;
            color: #0070C0;
            text-decoration: underline;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed; /* Critical for keeping content within the 19cm width */
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 13px;
            word-wrap: break-word;
        }

        .subjects-header {
            background-color: #f9f9f9;
            color: #2E7D32;
            font-weight: bold;
        }

        .info-table td {
            border: none;
            text-align: left;
            padding: 5px 0;
            font-size: 14px;
        }

        .info-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 150px;
            padding-left: 5px;
        }

        .comments {
            margin-top: 20px;
            line-height: 2;
            font-size: 14px;
        }

        .comment-line {
            border-bottom: 1px dashed #000;
            width: 70%;
            display: inline-block;
        }

        .footer-motto {
            text-align: center;
            color: #2E7D32;
            font-weight: bold;
            font-style: italic;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<?php use App\Http\Controllers\Helper; ?>

@foreach($students as $studentId => $results)
    @php
        $student = $results->first()->student;
        $totalMarks = $results->sum('marks');
        $average = $results->count() > 0 ? round($totalMarks / $results->count(), 2) : 0;
        $position = $loop->iteration; 
    @endphp

    <div class="report-card">
        <div class="header">
            <p style="margin: 0;">In the Name of Allah, the Most Gracious, the Most Merciful</p>
            <h1>{{ $schoolName }}</h1>
            <p class="motto">"Indeed we can"</p>
        </div>

        <div class="divider"></div>

        <div class="title-box">
            <span>REPORT CARD</span>
        </div>

        <table class="info-table">
            <tr>
                <td style="width: 60%;">Name: <span class="info-line">{{ $student->firstname }} {{ $student->lastname }}</span></td>
                <td>Class: <span class="info-line">{{ $className }}</span></td>
            </tr>
            <tr>
                <td>Term / Year: <span class="info-line">{{ $examName }}</span></td>
                <td>Date: <span class="info-line">{{ now()->format('d-m-Y') }}</span></td>
            </tr>
            <tr>
                <td>Position: <span class="info-line">{{ $position }}</span></td>
                <td>Number of Pupils: <span class="info-line">{{ $students->count() }}</span></td>
            </tr>
        </table>

        <table>
            <thead>
                <tr class="subjects-header">
                    <th style="width: 40%;">Subjects</th>
                    <th>Max Mark</th>
                    <th>Min Mark</th>
                    <th>Grade</th>
                    <th>Sign</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td style="text-align: left;">{{ Helper::item_md_name($result->subject_id) }}</td>
                        <td>100</td>
                        <td>0</td>
                        <td>{{ Helper::gradeFromAverage($result->marks) }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold; color: #2E7D32;">
                    <td>Total / Average</td>
                    <td colspan="2">{{ $totalMarks }}</td>
                    <td>{{ $average }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="comments">
            <div>Mid-term Results: <span class="comment-line"></span></div>
            <div>This term ends: <span class="comment-line"></span></div>
            <div>Next term begins: <span class="comment-line"></span></div>
            <div>Teacher's Comment: <span class="comment-line"></span></div>
            <div>Head Teacher's Comment: <span class="comment-line"></span></div>
            <div style="margin-top: 10px;">Sign: <span class="comment-line" style="width: 150px;"></span></div>
        </div>

        <div class="footer-motto">"Indeed we can"</div>
    </div>
@endforeach

</body>
</html>