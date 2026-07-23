{{-- Use the layout with sidebar --}}
@extends('layouts-side-bar.master')

@section('css')
    {{-- DataTables (if needed) --}}
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    {{-- Font Awesome & Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* ============================================
                   ROOT VARIABLES (KAMSSA Green Theme)
                   ============================================ */
        :root {
            --primary: #026837;
            --primary-light: #1E7A3D;
            --primary-lighter: #35804E;
            --primary-dark: #0C4A26;
            --primary-gradient: linear-gradient(135deg, #026837, #1E7A3D);
            --light: #E8F0E9;
            --white: #FFFFFF;
            --dark: #0C2915;
            --gray: #5F6C72;
            --gray-light: #F0F5F1;
            --success: #28A745;
            --warning: #FFC107;
            --danger: #DC3545;
            --info: #17A2B8;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.12);
            --radius: 10px;
            --radius-lg: 16px;
            --transition: all 0.25s ease;
        }

        /* ============================================
                   GLOBAL & LAYOUT
                   ============================================ */
        body {
            background: #f4f8f5;
        }

        .dashboard-container {
            padding: 20px 25px;
        }

        /* ============================================
                   WELCOME / CONGRATULATIONS CARD
                   ============================================ */
        .welcome-card {
            background: var(--primary-gradient);
            color: #fff;
            border-radius: var(--radius-lg);
            padding: 30px 35px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .welcome-left {
            position: relative;
            z-index: 1;
        }

        .welcome-left h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .welcome-left h2 i {
            font-size: 2.2rem;
            opacity: 0.9;
        }

        .welcome-left p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .welcome-right {
            position: relative;
            z-index: 1;
            text-align: right;
        }

        .welcome-right .big-number {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
        }

        .welcome-right .sub-text {
            font-size: 1rem;
            opacity: 0.85;
        }

        .welcome-right .trend-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 14px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 6px;
        }

        /* ============================================
                   STATS ROW
                   ============================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            border-radius: 0 4px 4px 0;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: rgba(2, 104, 55, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .stat-content {
            flex: 1;
        }

        .stat-title {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--gray);
            margin-bottom: 4px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.2;
        }

        .stat-change {
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
        }

        .stat-change.up {
            color: var(--success);
        }

        .stat-change.down {
            color: var(--danger);
        }

        /* ============================================
                   TWO‑COLUMN LAYOUT (Chart + Progress)
                   ============================================ */
        .row-cards {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 24px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .row-cards {
                grid-template-columns: 1fr;
            }
        }

        .card-box {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .card-box:hover {
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .card-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header .badge-date {
            font-size: 0.8rem;
            color: var(--gray);
            background: var(--gray-light);
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* ---- Doughnut chart wrapper ---- */
        .chart-wrapper {
            height: 200px;
            position: relative;
        }

        .chart-wrapper canvas {
            max-height: 100%;
            max-width: 100%;
        }

        /* ---- Progress bars ---- */
        .progress-item+.progress-item {
            margin-top: 18px;
        }

        .progress-item .label {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .progress-item .progress {
            height: 8px;
            border-radius: 6px;
            background: var(--gray-light);
            overflow: hidden;
        }

        .progress-item .progress-bar {
            background: var(--primary-gradient);
            height: 100%;
            border-radius: 6px;
        }

        /* ============================================
                   RECENT RESULTS TABLE
                   ============================================ */
        .table-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .table-header {
            padding: 18px 24px;
            background: var(--light);
            border-bottom: 1px solid rgba(2, 104, 55, 0.08);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .table-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-primary-sm {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary-sm:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 104, 55, 0.2);
        }

        .btn-outline-sm {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary-lighter);
        }

        .btn-outline-sm:hover {
            background: rgba(2, 104, 55, 0.05);
        }

        .table-responsive {
            overflow-x: auto;
            padding: 0 4px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .table-custom thead {
            background: var(--primary);
            color: #fff;
        }

        .table-custom th {
            padding: 14px 16px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .table-custom td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--gray-light);
            vertical-align: middle;
        }

        .table-custom tbody tr:hover {
            background: var(--gray-light);
        }

        .grade-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.75rem;
            text-align: center;
            min-width: 48px;
        }

        .grade-pass {
            background: rgba(2, 104, 55, 0.12);
            color: var(--primary);
            border: 1px solid rgba(2, 104, 55, 0.15);
        }

        .grade-fail {
            background: rgba(220, 53, 69, 0.12);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.15);
        }

        .action-btn {
            padding: 4px 10px;
            background: var(--gray-light);
            border: none;
            border-radius: 4px;
            color: var(--gray);
            font-size: 0.75rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .action-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        /* ============================================
                   QUICK ACTIONS (Cards)
                   ============================================ */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .quick-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.02);
            text-decoration: none;
            color: var(--dark);
        }

        .quick-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-light);
        }

        .quick-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .quick-info h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .quick-info p {
            font-size: 0.8rem;
            color: var(--gray);
            margin: 0;
        }

        /* ============================================
                   LATEST UPDATES (like in the screenshot)
                   ============================================ */
        .updates-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .update-item {
            background: var(--white);
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--shadow);
            text-align: center;
            border-left: 4px solid var(--primary);
        }

        .update-item .number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
        }

        .update-item .label {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }

        .update-item .sub {
            font-size: 0.75rem;
            color: var(--gray);
            margin-top: 4px;
        }

        /* ============================================
                   ANIMATIONS
                   ============================================ */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            animation: fadeUp 0.5s ease forwards;
        }

        /* ============================================
                   RESPONSIVE TWEAKS
                   ============================================ */
        @media (max-width: 768px) {
            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .welcome-right {
                text-align: left;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .table-actions {
                justify-content: stretch;
            }

            .table-actions .btn-sm {
                flex: 1;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-grid {
                grid-template-columns: 1fr;
            }

            .updates-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">

        <!-- ===== WELCOME / CONGRATULATIONS CARD ===== -->
        <div class="welcome-card animate-card" style="animation-delay: 0.1s;">
            <div class="welcome-left">
                <h2><i class="fas fa-trophy"></i> Welcome back, Admin</h2>
                <p>{{ $systemSettings->tagline ?? "Uganda's trusted secondary examination board" }}</p>
            </div>
            <div class="welcome-right">
                <div class="big-number">{{ $overallPassRate ?? 0 }}%</div>
                <div class="sub-text">Overall Pass Rate</div>
                <span class="trend-badge"><i class="fas fa-arrow-up me-1"></i> +12% vs last term</span>
            </div>
        </div>

        <!-- ===== STATS ROW ===== -->
        <div class="stats-grid">
            <div class="stat-card animate-card" style="animation-delay: 0.2s;">
                <div class="stat-icon"><i class="fas fa-school"></i></div>
                <div class="stat-content">
                    <div class="stat-title">Registered Schools</div>
                    <div class="stat-number">{{ number_format($totalSchools) }}</div>
                    <div class="stat-change up"><i class="fas fa-arrow-up"></i> +5%</div>
                </div>
            </div>
            <div class="stat-card animate-card" style="animation-delay: 0.25s;">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-content">
                    <div class="stat-title">Students</div>
                    <div class="stat-number">{{ number_format($totalStudents) }}</div>
                    <div class="stat-change up"><i class="fas fa-arrow-up"></i> +8.2%</div>
                </div>
            </div>
            <div class="stat-card animate-card" style="animation-delay: 0.3s;">
                <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                <div class="stat-content">
                    <div class="stat-title">Exams Conducted</div>
                    <div class="stat-number">{{ number_format($totalExamsConducted) }}</div>
                    <div class="stat-change down"><i class="fas fa-arrow-down"></i> -2%</div>
                </div>
            </div>
            <div class="stat-card animate-card" style="animation-delay: 0.35s;">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="stat-content">
                    <div class="stat-title">Average Score</div>
                    <div class="stat-number">{{ $averagePercentage }}%</div>
                    <div class="stat-change up"><i class="fas fa-arrow-up"></i> +3.5%</div>
                </div>
            </div>
        </div>

        <!-- ===== TWO‑COLUMN: CHART + PROGRESS ===== -->
        <div class="row-cards">
            <!-- Grade Distribution Chart -->
            <div class="card-box animate-card" style="animation-delay: 0.4s;">
                <div class="card-header">
                    <h4><i class="fas fa-chart-pie"></i> Grade Distribution</h4>
                    <span class="badge-date">This Term</span>
                </div>
                @if($gradeDistribution->count())
                    <div class="chart-wrapper">
                        <canvas id="gradeDistributionChart"></canvas>
                    </div>
                @else
                    <div style="text-align:center; padding:30px 0; color:var(--gray);">
                        <i class="fas fa-chart-pie" style="font-size:2.5rem; opacity:0.3;"></i>
                        <p class="mt-2">No graded results yet.</p>
                    </div>
                @endif
            </div>

            <!-- Performance Overview (Progress Bars) -->
            <div class="card-box animate-card" style="animation-delay: 0.45s;">
                <div class="card-header">
                    <h4><i class="fas fa-chart-simple"></i> Performance Overview</h4>
                    <span class="badge-date">Overall</span>
                </div>
                <div style="margin-bottom: 20px;">
                    <div class="progress-item">
                        <div class="label"><span>Average Score</span><strong>{{ $averagePercentage }}%</strong></div>
                        <div class="progress">
                            <div class="progress-bar" style="width:{{ $averagePercentage }}%;"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="label"><span>Pass Rate</span><strong>{{ $overallPassRate }}%</strong></div>
                        <div class="progress">
                            <div class="progress-bar" style="width:{{ $overallPassRate }}%;"></div>
                        </div>
                    </div>
                </div>
                <hr style="margin:18px 0; border-color:var(--gray-light);">
                <h6 style="font-weight:700; color:var(--primary); margin-bottom:12px;">
                    <i class="fas fa-medal me-1"></i> Top Performing Schools
                </h6>
                @forelse($topSchools as $school)
                    <div class="progress-item">
                        <div class="label">
                            <span>{{ $school->House }}</span><strong>{{ round($school->avg_percentage, 1) }}%</strong></div>
                        <div class="progress">
                            <div class="progress-bar" style="width:{{ round($school->avg_percentage, 1) }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No data yet.</p>
                @endforelse
            </div>
        </div>

        <!-- ===== RECENT RESULTS TABLE ===== -->
        <div class="table-section animate-card" style="animation-delay: 0.5s;">
            <div class="table-header">
                <h4><i class="fas fa-clipboard-list"></i> Recent Results</h4>
                <div class="table-actions">
                    <button class="btn-sm btn-primary-sm"><i class="fas fa-download"></i> Download All</button>
                    <button class="btn-sm btn-outline-sm"><i class="fas fa-print"></i> Print</button>
                    <button class="btn-sm btn-outline-sm"><i class="fas fa-sync-alt"></i> Refresh</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Level</th>
                            <th>Year</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentResults as $result)
                            @php
                                $grade = strtoupper($result->grade ?? 'N/A');
                                $isFail = in_array($grade, ['F7', 'FAIL']);
                            @endphp
                            <tr>
                                <td><strong>{{ $result->Student_Name ?? $result->student_id }}</strong></td>
                                <td>{{ $result->category }}</td>
                                <td>{{ $result->year }}</td>
                                <td>{{ $result->percentage }}%</td>
                                <td>
                                    <span class="grade-badge {{ $isFail ? 'grade-fail' : 'grade-pass' }}">
                                        {{ $grade }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <button class="action-btn" onclick="viewResult({{ $result->id ?? 0 }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" onclick="downloadResult({{ $result->id ?? 0 }})">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No results recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== QUICK ACTIONS ===== -->
        <div class="quick-grid">
            <a href="{{ route('school.allSchools') }}" class="quick-card animate-card" style="animation-delay:0.6s;">
                <div class="quick-icon"><i class="fas fa-list-alt"></i></div>
                <div class="quick-info">
                    <h5>All Schools</h5>
                    <p>Manage institutions</p>
                </div>
            </a>
            <a href="{{ route('houses.create') }}" class="quick-card animate-card" style="animation-delay:0.65s;">
                <div class="quick-icon"><i class="fas fa-plus"></i></div>
                <div class="quick-info">
                    <h5>Add School</h5>
                    <p>Register new school</p>
                </div>
            </a>
            <a href="{{ route('import.marks') }}" class="quick-card animate-card" style="animation-delay:0.7s;">
                <div class="quick-icon"><i class="fas fa-file-upload"></i></div>
                <div class="quick-info">
                    <h5>Import Marks</h5>
                    <p>Upload exam data</p>
                </div>
            </a>
            <a href="{{ route('grading.dashboard') }}" class="quick-card animate-card" style="animation-delay:0.75s;">
                <div class="quick-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="quick-info">
                    <h5>Grading</h5>
                    <p>Review & release grades</p>
                </div>
            </a>
        </div>

        <!-- ===== LATEST UPDATES (like in reference) ===== -->
        <div class="updates-row">
            <div class="update-item animate-card" style="animation-delay:0.8s;">
                <div class="number">{{ number_format($totalStudents) }}</div>
                <div class="label">Total Students</div>
                <div class="sub"><i class="fas fa-arrow-up text-success"></i> +8% this term</div>
            </div>
            <div class="update-item animate-card" style="animation-delay:0.85s;">
                <div class="number">{{ number_format($totalExamsConducted) }}</div>
                <div class="label">Exams Conducted</div>
                <div class="sub"><i class="fas fa-arrow-down text-danger"></i> -2% from last year</div>
            </div>
            <div class="update-item animate-card" style="animation-delay:0.9s;">
                <div class="number">{{ $overallPassRate }}%</div>
                <div class="label">Pass Rate</div>
                <div class="sub"><i class="fas fa-arrow-up text-success"></i> +3.2%</div>
            </div>
            <div class="update-item animate-card" style="animation-delay:0.95s;">
                <div class="number">{{ number_format($topSchools->count()) }}</div>
                <div class="label">Top Schools Tracked</div>
                <div class="sub">This period</div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>  
@endsection

@section('js')
    {{-- Chart.js for the doughnut --}}
    <script src="{{ URL::asset('assets/plugins/chart/chart.bundle.js') }}"></script>

    @if($gradeDistribution->count())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('gradeDistributionChart');
                if (!ctx) return;
                new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($gradeDistribution->pluck('grade')) !!},
                        datasets: [{
                            data: {!! json_encode($gradeDistribution->pluck('total')) !!},
                            backgroundColor: ['#026837', '#1E7A3D', '#35804E', '#7CB88F', '#FFC107', '#DC3545'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 12,
                                    font: { size: 11 }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            });
        </script>
    @endif

    {{-- Placeholder functions for actions --}}
    <script>
        function viewResult(id) {
            alert('View result details for ID: ' + id);
        }
        function downloadResult(id) {
            alert('Download result PDF for ID: ' + id);
        }
    </script>
@endsection