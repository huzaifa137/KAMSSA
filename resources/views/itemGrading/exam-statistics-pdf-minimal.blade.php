<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Exam Statistics Report</title>
    <style>
        /* NO complex CSS - only basic properties with hyphens */
        body {
            font-family: 'DejaVu Sans', 'Amiri', 'Noto Naskh Arabic', sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        /* Header */
        .header-box {
            background-color: #17a2b8;
            color: white;
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
        }

        .header-box h1 {
            margin: 0;
            font-size: 18px;
        }

        .header-box h3 {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: normal;
        }

        /* Section titles */
        .section-head {
            background-color: #f0f0f0;
            padding: 8px;
            margin: 20px 0 10px;
            font-weight: bold;
            border-left: 4px solid #17a2b8;
        }

        .section-head-danger {
            background-color: #dc2626;
            color: white;
            padding: 8px;
            margin: 20px 0 10px;
            font-weight: bold;
            border-left: 4px solid #b91c1c;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background-color: #17a2b8;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: 600;
        }

        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* Badges - simple */
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            display: inline-block;
            font-weight: 500;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        /* Simple stat boxes */
        .stat-row {
            width: 100%;
            margin: 20px 0;
        }

        .stat-box {
            float: left;
            width: 32%;
            margin-right: 1%;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 4px;
        }

        .stat-box:last-child {
            margin-right: 0;
        }

        .stat-blue {
            background-color: #17a2b8;
        }

        .stat-green {
            background-color: #28a745;
        }

        .stat-red {
            background-color: #dc2626;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Summary card */
        .summary-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-top: 15px;
        }

        .summary-item {
            float: left;
            width: 33.33%;
        }

        .summary-label {
            font-size: 10px;
            color: #666;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #17a2b8;
        }

        /* Page break */
        .page-break {
            page-break-after: always;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
        }

        /* Arabic text support */
        .arabic-text {
            font-family: 'Amiri', 'Noto Naskh Arabic', 'DejaVu Sans', sans-serif;
            direction: rtl;
            unicode-bidi: embed;
            display: inline-block;
        }

        /* Background colors for rows */
        .bg-success-light {
            background-color: #e8f5e9;
        }

        .bg-danger-light {
            background-color: #fee2e2;
        }

        .bg-gray-light {
            background-color: #f8fafc;
        }

        /* Font weights */
        .fw-bold {
            font-weight: 700;
        }

        .text-danger {
            color: #b91c1c;
        }

        /* Rank styles */
        .rank {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 4px;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
        }

        .rank-gold {
            background-color: #ffd700;
            color: #78350f;
        }

        .rank-silver {
            background-color: #c0c0c0;
            color: #1e293b;
        }

        .rank-bronze {
            background-color: #cd7f32;
            color: white;
        }

        /* Subject name with Arabic support */
        .subject-name {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <?php use App\Http\Controllers\Helper; ?>

    <div class="header-box">
        <h1>EXAM STATISTICS REPORT</h1>
        <h3>{{ $year }} - {{ $category }} - {{ $levelName }}</h3>
    </div>

    <!-- 1. Schools Registered -->
    <div class="section-head">1. NUMBER OF SCHOOLS REGISTERED</div>
    <table>
        <thead>
            <tr>
                <th width="10%">S/N</th>
                <th width="45%">Level</th>
                <th width="45%">Number of Schools</th>
            </tr>
        </thead>
        <tbody>
            @php
                $levelCode = strpos($levelName, 'THANAWI') !== false ? 'TH' : 'ID';
                $schools = DB::table('class_allocation')
                    ->select(DB::raw("DISTINCT SUBSTRING_INDEX(Student_ID, '-', 2) as center_code"))
                    ->where('Student_ID', 'like', "%-$levelCode-%")
                    ->where('Student_ID', 'like', "%-$year")
                    ->get();
                $schoolCount = $schools->count();
            @endphp
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">{{ $levelName }}</td>
                <td class="text-center">{{ $schoolCount }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 2. Students Registered -->
    <div class="section-head">2. NUMBER OF STUDENTS REGISTERED</div>
    <table>
        <thead>
            <tr>
                <th width="10%">S/N</th>
                <th width="45%">{{ $levelName }}</th>
                <th width="45%">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">{{ $registeredStudents }}</td>
                <td class="text-center">{{ $registeredStudents }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 3. Grading Summary - Passing Grades Only -->
    <div class="section-head">3. GRADING SUMMARY - {{ $levelName }}</div>
    <table>
        <thead>
            <tr>
                <th width="8%">S/N</th>
                <th width="27%">Grade</th>
                <th width="13%">Male</th>
                <th width="13%">%</th>
                <th width="13%">Female</th>
                <th width="13%">%</th>
                <th width="13%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grades = ['D1', 'D2', 'C3', 'C4'];
                $labels = ['Excellent D1', 'Very good D2', 'Good C3', 'Pass C4'];
                $serial = ['a', 'b', 'c', 'd'];
                $passingMaleTotal = $totals['male_total'] - $failedBreakdown['male_failed'];
                $passingFemaleTotal = $totals['female_total'] - $failedBreakdown['female_failed'];
                $passingTotal = $totals['overall_total'] - $failedBreakdown['total_failed'];
            @endphp

            @foreach($grades as $index => $grade)
                @if(isset($gradingSummary[$grade]))
                    <tr>
                        <td class="text-center">{{ $serial[$index] }}.</td>
                        <td>{{ $labels[$index] }}</td>
                        <td class="text-center">{{ $gradingSummary[$grade]['male_count'] }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $gradingSummary[$grade]['male_percent'] }}%</span>
                        </td>
                        <td class="text-center">{{ $gradingSummary[$grade]['female_count'] }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $gradingSummary[$grade]['female_percent'] }}%</span>
                        </td>
                        <td class="text-center fw-bold">{{ $gradingSummary[$grade]['total'] }}</td>
                    </tr>
                @endif
            @endforeach

            <!-- Failed Row (F) -->
            <tr style="background-color: #fee2e2;">
                <td class="text-center">e.</td>
                <td class="fw-bold text-danger">Fail F</td>
                <td class="text-center text-danger">{{ $failedBreakdown['male_failed'] }}</td>
                <td class="text-center">
                    <span class="badge badge-danger">
                        {{ $totals['overall_total'] > 0 ? round(($failedBreakdown['male_failed'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center text-danger">{{ $failedBreakdown['female_failed'] }}</td>
                <td class="text-center">
                    <span class="badge badge-danger">
                        {{ $totals['overall_total'] > 0 ? round(($failedBreakdown['female_failed'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center fw-bold text-danger">{{ $failedBreakdown['total_failed'] }}</td>
            </tr>

            <!-- Subtotal for Passing Grades -->
            <tr style="background-color: #e8f5e9; font-weight: bold;">
                <td colspan="2" class="text-right">Subtotal (Passing Grades D1-C4)</td>
                <td class="text-center">{{ $passingMaleTotal }}</td>
                <td class="text-center">
                    <span class="badge badge-success">
                        {{ $totals['overall_total'] > 0 ? round(($passingMaleTotal / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center">{{ $passingFemaleTotal }}</td>
                <td class="text-center">
                    <span class="badge badge-success">
                        {{ $totals['overall_total'] > 0 ? round(($passingFemaleTotal / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center">{{ $passingTotal }}</td>
            </tr>

            <!-- Grand Total All Students -->
            <tr style="background-color: #f0f0f0; font-weight: bold; border-top: 2px solid #17a2b8;">
                <td colspan="2" class="text-right">GRAND TOTAL (All Students)</td>
                <td class="text-center">{{ $totals['male_total'] }}</td>
                <td class="text-center">
                    <span class="badge badge-info">
                        {{ $totals['male_total'] > 0 ? round(($totals['male_total'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center">{{ $totals['female_total'] }}</td>
                <td class="text-center">
                    <span class="badge badge-info">
                        {{ $totals['female_total'] > 0 ? round(($totals['female_total'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center">{{ $totals['overall_total'] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Verification note -->
    <div style="font-size: 9px; color: #666; margin-top: 5px; text-align: right;">
        * Passing Grades: {{ $passingTotal }} students | Failed: {{ $failedBreakdown['total_failed'] }} students | Total: {{ $totals['overall_total'] }} students
    </div>

    <!-- 4. Failed Students Section -->
    <div class="section-head-danger">4. STUDENTS FAILED - {{ $levelName }}</div>
    <table>
        <thead>
            <tr>
                <th width="35%">Category</th>
                <th width="21.67%">Male</th>
                <th width="21.67%">Female</th>
                <th width="21.66%">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="fw-bold">Failed Students (Grade F)</td>
                <td class="text-center">
                    <span style="background-color: #fee2e2; color: #b91c1c; padding: 3px 10px; border-radius: 12px; font-weight: 500;">
                        {{ $failedBreakdown['male_failed'] }}
                    </span>
                </td>
                <td class="text-center">
                    <span style="background-color: #fee2e2; color: #b91c1c; padding: 3px 10px; border-radius: 12px; font-weight: 500;">
                        {{ $failedBreakdown['female_failed'] }}
                    </span>
                </td>
                <td class="text-center">
                    <span style="background-color: #fee2e2; color: #b91c1c; padding: 3px 10px; border-radius: 12px; font-weight: 500;">
                        {{ $failedBreakdown['total_failed'] }}
                    </span>
                </td>
            </tr>
            <!-- Percentage row for failed students -->
            <tr style="background-color: #f8fafc;">
                <td class="text-right fw-bold">Percentage of Total</td>
                <td class="text-center">
                    <span class="badge badge-danger">
                        {{ $totals['overall_total'] > 0 ? round(($failedBreakdown['male_failed'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center">
                    <span class="badge badge-danger">
                        {{ $totals['overall_total'] > 0 ? round(($failedBreakdown['female_failed'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
                <td class="text-center">
                    <span class="badge badge-danger">
                        {{ $totals['overall_total'] > 0 ? round(($failedBreakdown['total_failed'] / $totals['overall_total']) * 100, 2) : 0 }}%
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- 5. Top 10 Students -->
    <div class="section-head">5. TOP 10 PERFORMING STUDENTS - {{ $levelName }}</div>
    <table>
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="12%">Student ID</th>
                <th width="20%">Name</th>
                <th width="20%">School</th>
                <th width="8%">Gender</th>
                <th width="10%">Marks</th>
                <th width="12%">Percentage</th>
                <th width="10%">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topStudents as $index => $student)
                <tr>
                    <td class="text-center">
                        @if($index == 0)
                            <span class="rank rank-gold">1st</span>
                        @elseif($index == 1)
                            <span class="rank rank-silver">2nd</span>
                        @elseif($index == 2)
                            <span class="rank rank-bronze">3rd</span>
                        @else
                            <span class="rank" style="background-color: #f1f5f9; border: 1px solid #ddd;">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td>{{ $student['student_id'] }}</td>
                    <td>{{ Helper::getStudentName($student['student_id']) }}</td>
                    <td>{{ $student['school_name'] }}</td>
                    <td class="text-center">
                        @if(strtolower($student['gender']) == 'male')
                            <span class="badge badge-info">♂ Male</span>
                        @else
                            <span class="badge badge-danger">♀ Female</span>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($student['total_marks'], 2) }}</td>
                    <td class="text-center">
                        <span class="badge badge-success">{{ number_format($student['percentage'], 2) }}%</span>
                    </td>
                    <td class="text-center">{{ $student['grade'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 6. Best Performing Subjects -->
    <div class="section-head">6. TOP 10 BEST PERFORMING SUBJECTS</div>
    <table>
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="37%">Subject Name</th>
                <th width="15%">Students</th>
                <th width="15%">Average %</th>
                <th width="15%">Highest %</th>
                <th width="10%">Pass Rate %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bestSubjects as $index => $subject)
                <tr>
                    <td class="text-center">
                        @if($index == 0)<span class="badge badge-success">1st</span>
                        @elseif($index == 1)<span class="badge badge-info">2nd</span>
                        @elseif($index == 2)<span class="badge badge-warning">3rd</span>
                        @else{{ $index + 1 }}@endif
                    </td>
                    <td>
                        <span class="subject-name">
                            {{ Helper::item_md_name($subject['subject_id']) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $subject['student_count'] }}</td>
                    <td class="text-center">
                        <span class="badge badge-success">{{ number_format($subject['average'], 2) }}%</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info">{{ $subject['highest'] }}%</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-success">{{ $subject['pass_percentage'] }}%</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 7. Worst Performing Subjects -->
    <div class="section-head">7. TOP 10 WORST PERFORMING SUBJECTS</div>
    <table>
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="37%">Subject Name</th>
                <th width="15%">Students</th>
                <th width="15%">Average %</th>
                <th width="15%">Lowest %</th>
                <th width="10%">Pass Rate %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($worstSubjects as $index => $subject)
                <tr>
                    <td class="text-center">
                        @if($index == 0)<span class="badge badge-danger">1st</span>
                        @elseif($index == 1)<span class="badge badge-warning">2nd</span>
                        @elseif($index == 2)<span class="badge badge-info">3rd</span>
                        @else{{ $index + 1 }}@endif
                    </td>
                    <td>
                        <span class="subject-name">
                            {{ Helper::item_md_name($subject['subject_id']) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $subject['student_count'] }}</td>
                    <td class="text-center">
                        <span class="badge badge-warning">{{ number_format($subject['average'], 2) }}%</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-danger">{{ $subject['lowest'] }}%</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-danger">{{ $subject['pass_percentage'] }}%</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Generated on: {{ date('F j, Y, g:i a') }} | Report ID: {{ uniqid() }}
    </div>
</body>

</html>