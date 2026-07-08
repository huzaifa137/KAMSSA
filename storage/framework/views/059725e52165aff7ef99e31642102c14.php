<?php
use App\Http\Controllers\Helper;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
$controller = new Controller();
?>

<?php $__env->startSection('css'); ?>
    <!---jvectormap css-->
    <link href="<?php echo e(URL::asset('assets/plugins/jvectormap/jqvmap.css')); ?>" rel="stylesheet" />
    <!-- Data table css -->
    <link href="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
    <!--Daterangepicker css-->
    <link href="<?php echo e(URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #026837;
            --primary-light: #1E7A3D;
            --primary-lighter: #35804E;
            --light: #E8F0E9;
            --white: #FFFFFF;
            --dark: #0C2915;
            --gray: #5F6C72;
            --gray-light: #F0F5F1;
            --success: #28A745;
            --warning: #FFC107;
            --danger: #DC3545;
            --info: #17A2B8;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 6px 16px rgba(0, 0, 0, 0.1);
            --radius: 8px;
            --radius-lg: 12px;
            --transition: all 0.2s ease;
        }

        /* Compact Welcome Header */
        .welcome-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: var(--radius-lg);
            padding: 25px 30px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .welcome-header::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -15%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .welcome-greeting {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .welcome-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .student-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 20px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.12);
            padding: 15px;
            border-radius: var(--radius);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .info-label {
            font-size: 0.8rem;
            opacity: 0.85;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-label i {
            font-size: 0.9rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Compact Stats Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .stat-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(13, 75, 30, 0.08);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .stat-info {
            flex: 1;
        }

        .stat-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
            color: var(--primary);
            margin-bottom: 3px;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gray);
        }

        .trend-up {
            color: var(--primary-light);
        }

        .trend-down {
            color: var(--danger);
        }

        /* Compact Results Section */
        .results-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 25px;
        }

        .section-header {
            padding: 18px 25px;
            background: var(--light);
            border-bottom: 1px solid rgba(13, 75, 30, 0.1);
        }

        .section-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(13, 75, 30, 0.12);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary-lighter);
        }

        .btn-outline:hover {
            background-color: rgba(13, 75, 30, 0.04);
            transform: translateY(-1px);
        }

        /* Compact Results Table */
        .results-table-container {
            padding: 0;
            overflow-x: auto;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .results-table thead {
            background-color: var(--primary);
            color: var(--white);
        }

        .results-table th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .results-table tbody tr {
            border-bottom: 1px solid var(--light);
            transition: background-color 0.2s ease;
        }

        .results-table tbody tr:hover {
            background-color: var(--light);
        }

        .results-table td {
            padding: 14px 16px;
            color: var(--dark);
            vertical-align: middle;
        }

        .grade-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.8rem;
            text-align: center;
            min-width: 50px;
        }

        .grade-a {
            background-color: rgba(13, 75, 30, 0.1);
            color: var(--primary);
            border: 1px solid rgba(13, 75, 30, 0.2);
        }

        .grade-b {
            background-color: rgba(30, 122, 61, 0.1);
            color: var(--primary-light);
            border: 1px solid rgba(30, 122, 61, 0.2);
        }

        .grade-c {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .grade-d {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .action-cell {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            background: var(--light);
            border: none;
            color: var(--gray);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* Compact Performance Grid */
        .performance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .performance-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .performance-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .performance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .performance-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .performance-chart {
            height: 150px;
            background: linear-gradient(45deg, #f8fcf9, var(--light));
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            margin-bottom: 15px;
        }

        .chart-placeholder {
            text-align: center;
        }

        .chart-placeholder i {
            font-size: 2.2rem;
            margin-bottom: 10px;
            opacity: 0.25;
            color: var(--primary);
        }

        .chart-placeholder p {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .chart-placeholder small {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .performance-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .performance-stat {
            text-align: center;
            padding: 12px;
            background: var(--light);
            border-radius: var(--radius);
            border: 1px solid rgba(13, 75, 30, 0.08);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray);
            font-weight: 500;
        }

        /* Compact Quick Actions */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .action-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--dark);
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(13, 75, 30, 0.08);
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-lighter);
            background: var(--light);
        }

        .action-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .action-card:hover .action-icon {
            transform: rotate(-5deg) scale(1.05);
        }

        .action-info h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--primary);
        }

        .action-info p {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.4;
        }

        .badge-new {
            background-color: rgba(13, 75, 30, 0.1);
            color: var(--primary);
        }

        .notification-content p {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.4;
            margin-bottom: 6px;
        }

        .notification-time {
            font-size: 0.8rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .notification-time i {
            font-size: 0.75rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .welcome-greeting {
                font-size: 1.6rem;
            }

            .student-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .stats-overview {
                grid-template-columns: repeat(2, 1fr);
            }

            .performance-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .welcome-header {
                padding: 20px;
            }

            .welcome-greeting {
                font-size: 1.4rem;
                gap: 8px;
            }

            .student-info-grid {
                grid-template-columns: 1fr;
            }

            .stats-overview {
                grid-template-columns: 1fr;
            }

            .section-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .results-table {
                min-width: 700px;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .performance-stat {
                padding: 10px;
            }

            .stat-number {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .welcome-greeting {
                font-size: 1.2rem;
            }

            .stat-content {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }

            .action-cell {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .notification-item {
                padding: 12px 15px;
            }
        }

        /* Enhanced Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 75, 30, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(13, 75, 30, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 75, 30, 0);
            }
        }

        .animate-card {
            animation: fadeInUp 0.4s ease forwards;
        }

        .badge-new {
            animation: pulse 2s infinite;
        }

        /* Custom Scrollbar */
        .results-table-container::-webkit-scrollbar {
            height: 6px;
        }

        .results-table-container::-webkit-scrollbar-track {
            background: var(--light);
            border-radius: 3px;
        }

        .results-table-container::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        .results-table-container::-webkit-scrollbar-thumb:hover {
            background: var(--primary-light);
        }

        /* Loading Spinner */
        .spinner {
            width: 30px;
            height: 30px;
            border: 3px solid var(--light);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Subtle Hover Effects */
        .btn,
        .action-btn,
        .action-card,
        .stat-card,
        .performance-card {
            cursor: pointer;
        }

        /* Focus States for Accessibility */
        .btn:focus,
        .action-btn:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Text Utilities */
        .text-muted {
            color: var(--gray);
            font-size: 0.85rem;
        }

        .text-primary {
            color: var(--primary);
        }
    </style>
    </head>

    <body>
        <div class="dashboard-container">
            <!-- Welcome Header -->
            <div class="welcome-header animate-card mt-6" style="animation-delay: 0.1s;">
                <div class="welcome-content">
                    <div class="welcome-greeting">
                        <i class="fas fa-user-graduate"></i>
                        Idaad & Thanawi Grading Dashboard
                    </div>
                    <p class="welcome-subtitle">
                        Manage Idaad & Thanawi results, track performance, and oversee records.
                    </p>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="stat-card gradient-1 animate-card"
                    style="
                            animation-delay: 0.2s;
                            transition: all 0.3s ease;
                            transform: translateY(0);
                        "
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-title">Examinations Taken</div>
                            <div class="stat-value"><?php echo e($overallExamsTaken ?? 'No '); ?></div>
                        </div>
                    </div>
                </div>

                <div class="stat-card gradient-2 animate-card"
                                        style="
                            animation-delay: 0.3s;
                            transition: all 0.3s ease;
                            transform: translateY(0);
                        "
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-title">Average Grade</div>
                            <div class="stat-value"><?php echo e($overallAverageGrade); ?></div>
                        </div>
                    </div>
                </div>

                <div class="stat-card gradient-3 animate-card"
                    style="
        animation-delay: 0.4s;
        transition: all 0.3s ease;
        transform: translateY(0);
    "
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-title">Total Aggregate</div>
                            <div class="stat-value"><?php echo e($overallAggregate); ?></div>
                           
                        </div>
                    </div>
                </div>

                <div class="stat-card gradient-4 animate-card"
                    style="
        animation-delay: 0.5s;
        transition: all 0.3s ease;
        transform: translateY(0);
    "
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-title">Subjects Passed</div>
                            <div class="stat-value"><?php echo e($overallPassPercentage); ?>%</div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Results Section -->
            <div class="results-section animate-card" style="animation-delay: 0.6s">
                <div class="section-header">
                    <h3><i class="fas fa-clipboard-list"></i> Recent Examination Results</h3>
                    <div class="section-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-download"></i> Download All Results
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-print"></i> Print Summary
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-sync-alt"></i> Refresh Results
                        </button>
                    </div>
                </div>

                <div class="results-table-container">
    <table class="results-table">
        <thead>
            <tr>
                <th>Examination</th>
                <th>Year</th>
                <th>Type</th>
                <th>Subjects</th>
                <th>Aggregate</th>
                <th>Division</th>
                <th>Overall Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <strong><?php echo e($exam->exam_name); ?></strong>
                        <div class="text-muted" style="font-size: 0.9rem;">
                            <?php echo e($exam->exam_type); ?> Level
                        </div>
                    </td>
                    <td><?php echo e($exam->academic_year); ?></td>
                    <td><span class="grade-badge grade-<?php echo e(strtolower($exam->grade)); ?>"><?php echo e($exam->exam_type); ?></span></td>
                    <td><?php echo e($exam->total_subjects); ?> Subjects</td>
                    <td><strong><?php echo e($exam->aggregate); ?></strong></td>
                    <td><span class="grade-badge grade-<?php echo e(strtolower($exam->grade)); ?>"><?php echo e($exam->division); ?></span></td>
                    <td><span class="grade-badge grade-<?php echo e(strtolower($exam->grade)); ?>"><?php echo e($exam->grade); ?></span></td>
                    <td class="action-cell">
                        <button class="action-btn" onclick="viewDetails(<?php echo e($exam->exam_id); ?>)">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="action-btn" onclick="downloadResults(<?php echo e($exam->exam_id); ?>)">
                            <i class="fas fa-download"></i> PDF
                        </button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center">No exam results found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

            </div>

            <!-- Performance Summary -->
            <div class="performance-grid">
                <div class="performance-card animate-card"
                    style="
                            animation-delay: 0.7s;
                            transition: all 0.3s ease;
                            transform: translateY(0);
                        "
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div class="performance-header">
                        <h4><i class="fas fa-chart-pie"></i> Grade Distribution</h4>
                        <span class="text-muted">Current Year</span>
                    </div>
                    <div class="performance-chart">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-pie"></i>
                            <p>Grade Distribution Chart</p>
                            <small>Visual representation of your grades</small>
                        </div>
                    </div>
                    <div class="performance-stats">
                        <div class="performance-stat">
                            <div class="stat-number">4</div>
                            <div class="stat-label">Grade A</div>
                        </div>
                        <div class="performance-stat">
                            <div class="stat-number">2</div>
                            <div class="stat-label">Grade B</div>
                        </div>
                        <div class="performance-stat">
                            <div class="stat-number">1</div>
                            <div class="stat-label">Grade C</div>
                        </div>
                        <div class="performance-stat">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Grade D/F</div>
                        </div>
                    </div>
                </div>

                <div class="performance-card animate-card"
                    style="
        animation-delay: 0.8s;
        transition: all 0.3s ease;
        transform: translateY(0);
    "
                    onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div class="performance-header">
                        <h4><i class="fas fa-chart-line"></i> Performance Trend</h4>
                        <span class="text-muted">Last 3 Years</span>
                    </div>
                    <div class="performance-chart">
                        <div class="chart-placeholder">
                            <i class="fas fa-chart-line"></i>
                            <p>Performance Trend Chart</p>
                            <small>Your academic progress over time</small>
                        </div>
                    </div>
                    <div class="performance-stats">
                        <div class="performance-stat">
                            <div class="stat-number">2024</div>
                            <div class="stat-label">Grade A</div>
                        </div>
                        <div class="performance-stat">
                            <div class="stat-number">2023</div>
                            <div class="stat-label">Grade A-</div>
                        </div>
                        <div class="performance-stat">
                            <div class="stat-number">2022</div>
                            <div class="stat-label">Grade B+</div>
                        </div>
                        <div class="performance-stat">
                            <div class="stat-number">2021</div>
                            <div class="stat-label">Grade C+</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions-grid">
                <a href="#" class="action-card animate-card" style="animation-delay: 0.9s"
                    onclick="showAllResults()">
                    <div class="action-icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div class="action-info">
                        <h4>View All Results</h4>
                        <p>Access complete examination history</p>
                    </div>
                </a>

                <a href="#" class="action-card animate-card" style="animation-delay: 1s"
                    onclick="requestTranscript()">
                    <div class="action-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="action-info">
                        <h4>Request Transcript</h4>
                        <p>Apply for official academic transcript</p>
                    </div>
                </a>

                <a href="#" class="action-card animate-card" style="animation-delay: 1.1s"
                    onclick="viewStatistics()">
                    <div class="action-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="action-info">
                        <h4>Performance Analytics</h4>
                        <p>Detailed performance analysis</p>
                    </div>
                </a>

                <a href="#" class="action-card animate-card" style="animation-delay: 1.2s"
                    onclick="contactSupport()">
                    <div class="action-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="action-info">
                        <h4>Support & Help</h4>
                        <p>Get assistance with your results</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- SweetAlert Script -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // SweetAlert customization for Uganda theme
            const SwalTheme = Swal.mixin({
                customClass: {
                    confirmButton: 'btn-confirm',
                    cancelButton: 'btn-cancel'
                },
                buttonsStyling: false,
                background: '#F8FCF9',
                color: '#0C2915'
            });

            // View Results Details
            function viewDetails(examId) {
                SwalTheme.fire({
                    title: 'Examination Details',
                    html: `
                                <div style="text-align: left;">
                                    <h4 style="color: var(--primary); margin-bottom: 15px;">${examId === 'thanawi2024' ? 'Thanawi Final Examination 2024' :
                            examId === 'idaad2022' ? 'Idaad Final Examination 2022' :
                                examId === 'midterm2023' ? 'Mid-Term Assessment 2023' : 'Pre-Mock Examination 2021'}</h4>

                                    <div style="background: #f8fcf9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                        <strong>Subject Grades:</strong><br>
                                        ${examId === 'thanawi2024' ?
                            'Mathematics: A<br>Physics: A-<br>Chemistry: B+<br>Biology: A<br>Computer Studies: A+<br>General Paper: C+' :
                            examId === 'idaad2022' ?
                                'Arabic: B+<br>Islamic Studies: A<br>Mathematics: B<br>English: C+<br>Science: B+<br>Social Studies: A-' :
                                examId === 'midterm2023' ?
                                    'Advanced Mathematics: A<br>Physics: A-<br>Chemistry: B+<br>Biology: B<br>Computer Studies: A' :
                                    'Arabic: C+<br>Islamic Studies: B<br>Mathematics: D<br>English: C<br>Science: C+<br>Social Studies: B-'}
                                    </div>

                                    <p><strong>Examination Date:</strong> ${examId === 'thanawi2024' ? 'May 15-30, 2024' :
                            examId === 'idaad2022' ? 'March 10-25, 2022' :
                                examId === 'midterm2023' ? 'October 5-10, 2023' : 'February 20-25, 2021'}</p>
                                    <p><strong>Center:</strong> Kampala Islamic High School</p>
                                    <p><strong>Status:</strong> Officially Verified</p>
                                </div>
                            `,
                    icon: 'info',
                    confirmButtonText: 'Download PDF',
                    showCancelButton: true,
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        downloadResults(examId);
                    }
                });
            }

            // Download Results
            function downloadResults(examId) {
                SwalTheme.fire({
                    title: 'Downloading Results',
                    html: `
                                <div style="text-align: center; padding: 20px 0;">
                                    <i class="fas fa-file-download" style="font-size: 48px; color: var(--primary); margin-bottom: 15px;"></i>
                                    <p>Your ${examId} results are being prepared for download...</p>
                                    <div class="spinner" style="width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin: 20px auto;"></div>
                                </div>
                            `,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    SwalTheme.fire({
                        title: 'Download Ready!',
                        text: 'Your results PDF has been generated and is ready for download.',
                        icon: 'success',
                        confirmButtonText: 'Download Now'
                    });
                });
            }

            // Quick Actions Functions
            function showAllResults() {
                SwalTheme.fire({
                    title: 'All Examination Results',
                    text: 'Opening complete examination history...',
                    icon: 'info',
                    timer: 1500,
                    showConfirmButton: false
                });
            }

            function requestTranscript() {
                SwalTheme.fire({
                    title: 'Request Official Transcript',
                    html: `
                                <div style="text-align: left;">
                                    <p>Official transcripts are processed within 5-7 working days.</p>
                                    <div style="margin-top: 15px;">
                                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Delivery Method:</label>
                                        <select id="deliveryMethod" class="swal2-input">
                                            <option value="pickup">Pick up at Center</option>
                                            <option value="courier">Courier Delivery</option>
                                            <option value="digital">Digital Copy Only</option>
                                        </select>
                                    </div>
                                </div>
                            `,
                    showCancelButton: true,
                    confirmButtonText: 'Submit Request',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const method = document.getElementById('deliveryMethod').value;
                        return {
                            deliveryMethod: method
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        SwalTheme.fire({
                            title: 'Request Submitted!',
                            text: 'Your transcript request has been received. You will be notified when it\'s ready.',
                            icon: 'success'
                        });
                    }
                });
            }

            function viewStatistics() {
                SwalTheme.fire({
                    title: 'Performance Analytics',
                    html: `
                                <div style="text-align: center;">
                                    <div style="background: #f8fcf9; padding: 20px; border-radius: 10px; margin: 20px 0;">
                                        <h4 style="color: var(--primary); margin-bottom: 15px;">Your Performance Summary</h4>
                                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; text-align: left;">
                                            <div><strong>Average Grade:</strong> A-</div>
                                            <div><strong>Best Subject:</strong> Computer Studies (A+)</div>
                                            <div><strong>Improvement Rate:</strong> +15%</div>
                                            <div><strong>National Rank:</strong> Top 10%</div>
                                            <div><strong>Subjects Passed:</strong> 100%</div>
                                            <div><strong>Attendance Rate:</strong> 98%</div>
                                        </div>
                                    </div>
                                </div>
                            `,
                    confirmButtonText: 'View Detailed Report',
                    showCancelButton: true,
                    cancelButtonText: 'Close'
                });
            }

            function contactSupport() {
                SwalTheme.fire({
                    title: 'Contact Support',
                    html: `
                                <div style="text-align: left;">
                                    <p><strong>Ministry of Education Support:</strong></p>
                                    <p>📞 Phone: +256 800 123 456</p>
                                    <p>📧 Email: support@ugresults.go.ug</p>
                                    <p>🏢 Address: Ministry of Education, Kampala</p>
                                    <p>⏰ Hours: Mon-Fri, 8:00 AM - 6:00 PM</p>

                                    <div style="margin-top: 20px; padding: 15px; background: #f8fcf9; border-radius: 8px;">
                                        <strong>For immediate assistance:</strong>
                                        <p>1. Include your registration number</p>
                                        <p>2. Specify the examination year</p>
                                        <p>3. Describe your issue clearly</p>
                                    </div>
                                </div>
                            `,
                    confirmButtonText: 'Send Email',
                    showCancelButton: true,
                    cancelButtonText: 'Close'
                });
            }

            // Animate cards on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-card');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            });

            // Observe all cards for animation
            document.querySelectorAll(
                    '.welcome-header, .stat-card, .results-section, .performance-card, .action-card, .notifications-section')
                .forEach(card => {
                    observer.observe(card);
                });

            // Update current year in info if needed
            document.addEventListener('DOMContentLoaded', function() {
                const currentYear = new Date().getFullYear();
                document.querySelectorAll('.current-year').forEach(el => {
                    el.textContent = currentYear;
                });
            });

            // Auto-refresh notifications every 5 minutes
            setInterval(() => {
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    badge.style.animation = 'pulse 1s';
                    setTimeout(() => badge.style.animation = '', 1000);
                }
            }, 300000); // 5 minutes
        </script>
    </body>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!-- c3.js Charts js-->
    <script src="<?php echo e(URL::asset('assets/plugins/charts-c3/d3.v5.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/charts-c3/c3-chart.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/charts.js')); ?>"></script>

    <!-- ECharts js -->
    <script src="<?php echo e(URL::asset('assets/plugins/echarts/echarts.js')); ?>"></script>
    <!-- Peitychart js-->
    <script src="<?php echo e(URL::asset('assets/plugins/peitychart/jquery.peity.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/peitychart/peitychart.init.js')); ?>"></script>
    <!-- Apexchart js-->
    <script src="<?php echo e(URL::asset('assets/js/apexcharts.js')); ?>"></script>
    <!--Moment js-->
    <script src="<?php echo e(URL::asset('assets/plugins/moment/moment.js')); ?>"></script>
    <!-- Daterangepicker js-->
    <script src="<?php echo e(URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/daterange.js')); ?>"></script>
    <!---jvectormap js-->
    <script src="<?php echo e(URL::asset('assets/plugins/jvectormap/jquery.vmap.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js')); ?>"></script>
    <!-- Index js-->
    <script src="<?php echo e(URL::asset('assets/js/index1.js')); ?>"></script>
    <!-- Data tables js-->
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/datatables.js')); ?>"></script>
    <!--Counters -->
    <script src="<?php echo e(URL::asset('assets/plugins/counters/counterup.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/counters/waypoints.min.js')); ?>"></script>
    <!--Chart js -->
    <script src="<?php echo e(URL::asset('assets/plugins/chart/chart.bundle.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/chart/utils.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts-side-bar.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\huzaiphar\ple-examination-boards-updated\resources\views/student/dashboard.blade.php ENDPATH**/ ?>