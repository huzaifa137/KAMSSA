<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Exam Statistics Report</title>
    <style>
        /* NO complex CSS - only basic properties */
        body {
            font-family: 'dejavusans', 'amiri', 'Noto Naskh Arabic', sans-serif;
            font-size: 11px;
            margin: 20px;
            color: #333;
            line-height: 1.4;
        }

        /* Header */
        .header-box {
            background-color: #17a2b8;
            color: white;
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .header-box h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header-box h3 {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: normal;
        }

        /* Section titles */
        .section-head {
            background-color: #f0f0f0;
            padding: 8px 12px;
            margin: 20px 0 12px;
            font-weight: bold;
            border-left: 4px solid #17a2b8;
            font-size: 12px;
        }

        .section-head-danger {
            background-color: #dc2626;
            color: white;
            padding: 8px 12px;
            margin: 20px 0 12px;
            font-weight: bold;
            border-left: 4px solid #b91c1c;
            font-size: 12px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        th {
            background-color: #17a2b8;
            color: white;
            padding: 8px 6px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #0f7a8a;
            font-size: 10px;
        }

        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            vertical-align: middle;
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

        /* Arabic text handling */
        [dir="rtl"] {
            direction: rtl;
            text-align: right;
        }

        .arabic-text {
            font-family: 'amiri', 'dejavusans', 'Noto Naskh Arabic', sans-serif;
            direction: rtl;
            display: inline-block;
            unicode-bidi: embed;
            font-size: 10.5px;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 500;
            min-width: 35px;
            text-align: center;
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
            color: #333;
        }

        /* Background colors */
        .bg-success-light {
            background-color: #e8f5e9;
        }

        .bg-danger-light {
            background-color: #fee2e2;
        }

        .bg-gray-light {
            background-color: #f8fafc;
        }

        .bg-gray-medium {
            background-color: #f0f0f0;
        }

        /* Text utilities */
        .fw-bold {
            font-weight: 700;
        }

        .text-danger {
            color: #b91c1c;
        }

        .text-success {
            color: #28a745;
        }

        .text-muted {
            color: #666;
        }

        /* Rank styles */
        .rank {
            display: inline-block;
            width: 28px;
            height: 28px;
            border-radius: 4px;
            text-align: center;
            line-height: 28px;
            font-weight: bold;
            font-size: 10px;
        }

        .rank-gold {
            background-color: #ffd700;
            color: #78350f;
            border: 1px solid #e6b800;
        }

        .rank-silver {
            background-color: #c0c0c0;
            color: #1e293b;
            border: 1px solid #a0a0a0;
        }

        .rank-bronze {
            background-color: #cd7f32;
            color: white;
            border: 1px solid #b06b2a;
        }

        .rank-default {
            background-color: #f1f5f9;
            border: 1px solid #ddd;
        }

        /* Custom failed badge */
        .failed-badge {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: 500;
            display: inline-block;
            font-size: 9px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #666;
        }

        /* Subject name */
        .subject-name {
            font-weight: 600;
        }

        /* Page break */
        .page-break {
            page-break-after: always;
        }

        /* Small note */
        .small-note {
            font-size: 8px;
            color: #666;
            margin-top: 5px;
            margin-bottom: 10px;
            text-align: right;
            font-style: italic;
        }

        /* Gender badges */
        .gender-male {
            background-color: #17a2b8;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
        }

        .gender-female {
            background-color: #dc3545;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
        }

        /* Border top for grand total */
        .border-top-green {
            border-top: 2px solid #17a2b8;
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
                    ->where('Student_ID', 'like', "%-" . $year . "%")
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

    <!-- 3. Grading Summary -->
    <div class="section-head">3. GRADING SUMMARY - {{ $levelName }}</div>
    @php
        $passingMaleTotal = $totals['male_total'] - $failedBreakdown['male_failed'];
        $passingFemaleTotal = $totals['female_total'] - $failedBreakdown['female_failed'];
        $passingTotal = $totals['overall_total'] - $failedBreakdown['total_failed'];
    @endphp
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

            <!-- Failed Row -->
            <tr class="bg-danger-light">
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

            <!-- Subtotal Passing -->
            <tr class="bg-success-light fw-bold">
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

            <!-- Grand Total -->
            <tr class="bg-gray-medium fw-bold border-top-green">
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

    <div class="small-note">
        * Passing Grades: {{ $passingTotal }} students | Failed: {{ $failedBreakdown['total_failed'] }} students | Total: {{ $totals['overall_total'] }} students
    </div>

    <!-- 4. Failed Students -->
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
                    <span class="failed-badge">{{ $failedBreakdown['male_failed'] }}</span>
                </td>
                <td class="text-center">
                    <span class="failed-badge">{{ $failedBreakdown['female_failed'] }}</span>
                </td>
                <td class="text-center">
                    <span class="failed-badge">{{ $failedBreakdown['total_failed'] }}</span>
                </td>
            </tr>
            <tr class="bg-gray-light">
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
                            <span class="rank rank-gold">1</span>
                        @elseif($index == 1)
                            <span class="rank rank-silver">2</span>
                        @elseif($index == 2)
                            <span class="rank rank-bronze">3</span>
                        @else
                            <span class="rank rank-default">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td>{{ $student['student_id'] }}</td>
                    <td>{{ Helper::getStudentName($student['student_id']) }}</td>
                    <td>{{ $student['school_name'] }}</td>
                    <td class="text-center">
                        @if(strtolower($student['gender']) == 'male')
                            <span class="gender-male">♂ Male</span>
                        @else
                            <span class="gender-female">♀ Female</span>
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

    <!-- 6. Best Subjects -->
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
                @php
                    $subjectName = Helper::item_md_name($subject['subject_id']);
                    $hasArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $subjectName);
                @endphp
                <tr>
                    <td class="text-center">
                        @if($index == 0)<span class="badge badge-success">1</span>
                        @elseif($index == 1)<span class="badge badge-info">2</span>
                        @elseif($index == 2)<span class="badge badge-warning">3</span>
                        @else{{ $index + 1 }}@endif
                    </td>
                    <td>
                        @if($hasArabic)
                            <span dir="rtl" class="arabic-text">{{ $subjectName }}</span>
                        @else
                            <span class="subject-name">{{ $subjectName }}</span>
                        @endif
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

    <!-- 7. Worst Subjects -->
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
                @php
                    $subjectName = Helper::item_md_name($subject['subject_id']);
                    $hasArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $subjectName);
                @endphp
                <tr>
                    <td class="text-center">
                        @if($index == 0)<span class="badge badge-danger">1</span>
                        @elseif($index == 1)<span class="badge badge-warning">2</span>
                        @elseif($index == 2)<span class="badge badge-info">3</span>
                        @else{{ $index + 1 }}@endif
                    </td>
                    <td>
                        @if($hasArabic)
                            <span dir="rtl" class="arabic-text">{{ $subjectName }}</span>
                        @else
                            <span class="subject-name">{{ $subjectName }}</span>
                        @endif
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