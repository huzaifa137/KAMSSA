<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading Results - <?php echo e($schoolName); ?></title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #287C44;
        }

        .header h1 {
            color: #287C44;
            font-size: 18px;
            margin: 0 0 5px 0;
            padding: 0;
        }

        .header p {
            color: #666;
            margin: 3px 0;
            font-size: 11px;
        }

        .school-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #287C44;
        }

        .school-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .school-info td {
            padding: 3px 5px;
            font-size: 10px;
        }

        .school-info .label {
            font-weight: bold;
            color: #287C44;
            width: 120px;
        }

        /* Statistics Cards */
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            min-width: 120px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .stat-card .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-card .value {
            font-size: 16px;
            font-weight: bold;
            color: #287C44;
        }

        /* Distribution Tables - Updated for vertical stacking */
        .distribution-section {
            margin-bottom: 25px;
        }

        .distribution-block {
            margin-bottom: 20px;
            width: 100%;
        }

        .distribution-title {
            font-size: 12px;
            font-weight: bold;
            color: #287C44;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #287C44;
            background: #f0f7f0;
            padding: 8px 10px;
            border-radius: 4px 4px 0 0;
        }

        .full-width-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }

        .full-width-table th {
            background: #287C44;
            color: white;
            padding: 8px 10px;
            font-size: 10px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #1e5f33;
        }

        .full-width-table td {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            font-size: 10px;
        }

        .full-width-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .full-width-table tbody tr:hover {
            background: #e9ecef;
        }

        /* Stats summary cards inside tables */
        .stat-summary {
            display: inline-block;
            background: #e8f5e9;
            padding: 2px 8px;
            border-radius: 12px;
            color: #287C44;
            font-weight: bold;
            margin-left: 5px;
            font-size: 9px;
        }

        /* Main Results Table */
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 8px;
            border: 1px solid #dee2e6;
        }

        .results-table th {
            background: #287C44;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1e5f33;
            font-size: 9px;
        }

        .results-table td {
            padding: 6px 5px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .results-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        /* Grade Badges */
        .grade-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            min-width: 45px;
        }

        .grade-excellent {
            background: #28a745;
            color: white;
        }

        .grade-very-good {
            background: #007bff;
            color: white;
        }

        .grade-good {
            background: #ffc107;
            color: #333;
        }

        .grade-pass {
            background: #17a2b8;
            color: white;
        }

        .grade-fail {
            background: #dc3545;
            color: white;
        }

        /* Gender Badges */
        .gender-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 500;
        }

        .gender-male {
            background: #e3f2fd;
            color: #0d47a1;
            border: 1px solid #90caf9;
        }

        .gender-female {
            background: #fce4ec;
            color: #880e4f;
            border: 1px solid #f48fb1;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 10px;
            border-top: 2px solid #287C44;
            font-size: 8px;
            color: #6c757d;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Additional spacing */
        .mb-3 {
            margin-bottom: 15px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Total row styling */
        .total-row {
            background: #e8f5e9 !important;
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid #287C44;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>GRADING RESULTS REPORT</h1>
        <p>Generated on: <?php echo e($generated_date); ?></p>
    </div>

    <div class="school-info">
        <table>
            <tr>
                <td class="label">School Name:</td>
                <td><strong><?php echo e($schoolName); ?></strong></td>
                <td class="label">School Code:</td>
                <td><strong><?php echo e($schoolNumber); ?></strong></td>
            </tr>
            <tr>
                <td class="label">Category:</td>
                <td><?php echo e($category); ?></td>
                <td class="label">Academic Year:</td>
                <td><?php echo e($year); ?></td>
            </tr>
            <tr>
                <td class="label">Level:</td>
                <td><?php echo e($level ?? 'N/A'); ?></td>
                <td class="label">Total Students:</td>
                <td><strong><?php echo e($total_students); ?></strong></td>
            </tr>
        </table>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="label">Total Students</div>
            <div class="value"><?php echo e($statistics['count']); ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Average</div>
            <div class="value"><?php echo e(number_format($statistics['average'], 2)); ?>%</div>
        </div>
        <div class="stat-card">
            <div class="label">Highest</div>
            <div class="value"><?php echo e(number_format($statistics['highest'], 2)); ?>%</div>
        </div>
        <div class="stat-card">
            <div class="label">Lowest</div>
            <div class="value"><?php echo e(number_format($statistics['lowest'], 2)); ?>%</div>
        </div>
    </div>

    <div style="page-break-before: always;"></div>

    <!-- Distribution Section - Now stacked vertically -->
    <div class="distribution-section">
        <!-- Grade Distribution Table - Full Width -->
        <div class="distribution-block">
            <div class="distribution-title">
                <span>📊 Grade Distribution (Marks)</span>
                <span class="stat-summary">Total: <?php echo e($statistics['count']); ?> students</span>
            </div>
            <table class="full-width-table">
                <thead>
                    <tr>
                        <th width="25%">Grade Range</th>
                        <th width="25%">Count</th>
                        <th width="25%">Percentage</th>
                        <th width="25%">Visual Distribution</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $gradeRanges = [
                            'A (80-100%)' => $statistics['grade_distribution']['A'] ?? 0,
                            'B (70-79%)' => $statistics['grade_distribution']['B'] ?? 0,
                            'C (60-69%)' => $statistics['grade_distribution']['C'] ?? 0,
                            'D (50-59%)' => $statistics['grade_distribution']['D'] ?? 0,
                            'F (0-49%)' => $statistics['grade_distribution']['F'] ?? 0
                        ];
                    ?>
                    <?php $__currentLoopData = $gradeRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $percentage = $statistics['count'] > 0 ? round(($count / $statistics['count']) * 100, 1) : 0;
                            $barWidth = $percentage;
                        ?>
                        <tr>
                            <td><strong><?php echo e($range); ?></strong></td>
                            <td class="text-center"><?php echo e($count); ?></td>
                            <td class="text-center">
                                <span class="grade-badge <?php echo e($percentage >= 50 ? 'grade-excellent' : 'grade-fail'); ?>">
                                    <?php echo e($percentage); ?>%
                                </span>
                            </td>
                            <td>
                                <div
                                    style="background: #e9ecef; height: 12px; width: 100%; border-radius: 6px; overflow: hidden;">
                                    <div style="background: #287C44; height: 12px; width: <?php echo e($barWidth); ?>%;"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td><strong>Total Graded Students</strong></td>
                        <td class="text-center"><strong><?php echo e($statistics['count']); ?></strong></td>
                        <td class="text-center"><strong>100%</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Classification Distribution Table - Full Width -->
        <div class="distribution-block">
            <div class="distribution-title">
                <span>🏆 Classification Distribution (Points)</span>
                <span class="stat-summary">Total: <?php echo e($statistics['count']); ?> students</span>
            </div>
            <table class="full-width-table">
                <thead>
                    <tr>
                        <th width="33%">Classification</th>
                        <th width="33%">Count</th>
                        <th width="34%">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $classColors = [
                            'FIRST CLASS' => 'grade-excellent',
                            'SECOND CLASS UPPER' => 'grade-very-good',
                            'SECOND CLASS LOWER' => 'grade-good',
                            'THIRD CLASS' => 'grade-pass',
                            'FAIL' => 'grade-fail'
                        ];
                    ?>
                    <?php $__currentLoopData = $statistics['class_distribution']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $percentage = $statistics['count'] > 0 ? round(($count / $statistics['count']) * 100, 1) : 0;
                            $colorClass = $classColors[$class] ?? 'grade-fail';
                        ?>
                        <tr>
                            <td><strong><?php echo e($class); ?></strong></td>
                            <td class="text-center"><?php echo e($count); ?></td>
                            <td class="text-center">
                                <span class="grade-badge <?php echo e($colorClass); ?>">
                                    <?php echo e($percentage); ?>%
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td><strong>Total Students</strong></td>
                        <td class="text-center"><strong><?php echo e($statistics['count']); ?></strong></td>
                        <td class="text-center"><strong>100%</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Results Table -->
    <div class="distribution-title" style="margin-top: 20px;">
        <span>📋 Student Performance Details</span>
        <span class="stat-summary"><?php echo e($total_students); ?> records</span>
    </div>
    <table class="results-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Index Number</th>
                <th width="20%">Student Name</th>
                <th width="15%">School</th>
                <th width="8%">Gender</th>
                <th width="10%">Percentage</th>
                <th width="12%">Grade</th>
                <th width="15%">Classification</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studentId => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $studentSex = App\Models\StudentBasic::where('Student_ID', $studentId)->value('StudentSex');
                    $percentage = $result['percentage'];
                    $gradeClass = $percentage >= 80 ? 'grade-excellent' :
                        ($percentage >= 70 ? 'grade-very-good' :
                            ($percentage >= 60 ? 'grade-good' :
                                ($percentage >= 50 ? 'grade-pass' : 'grade-fail')));
                ?>
                <tr>
                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($studentId); ?></td>
                    <td><?php echo e(App\Http\Controllers\Helper::parseStudentId($studentId, 'student')); ?></td>
                    <td><?php echo e(App\Http\Controllers\Helper::parseStudentId($studentId, 'school')); ?></td>
                    <td class="text-center">
                        <span
                            class="gender-badge <?php echo e(strtolower($studentSex) == 'male' ? 'gender-male' : 'gender-female'); ?>">
                            <?php echo e(ucfirst($studentSex)); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <span class="grade-badge <?php echo e($gradeClass); ?>">
                            <?php echo e(number_format($percentage, 2)); ?>%
                        </span>
                    </td>
                    <td><strong><?php echo e($result['grade']); ?></strong></td>
                    <td><?php echo e($result['classification'] ?? 'N/A'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Summary Row -->
    <div
        style="margin-top: 15px; padding: 8px; background: #f8f9fa; border-radius: 4px; font-size: 9px; text-align: right;">
        <strong>Total Students Processed:</strong> <?php echo e($total_students); ?> |
        <strong>Generated:</strong> <?php echo e($generated_date); ?>

    </div>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
        <p>Generated by KAMSSA Examination Management System</p>
    </div>
</body>

</html><?php /**PATH C:\Users\USER\Desktop\KAMSSA\resources\views/itemGrading/pdf/grading-results.blade.php ENDPATH**/ ?>