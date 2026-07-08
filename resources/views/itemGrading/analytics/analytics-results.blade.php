{{-- resources/views/itemGrading/analytics-results.blade.php --}}
@extends('layouts-side-bar.master')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #16a085;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }

        body {
            background-color: #f8fafc;
        }

        .report-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .report-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(30deg);
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 700;
            color: var(--primary);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary), var(--info));
            border-radius: 2px;
        }

        .badge-pass {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
        }

        .badge-fail {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
        }

        .student-rank-1 {
            background: linear-gradient(135deg, #f1c40f, #f39c12);
            color: white;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
        }

        .student-rank-2 {
            background: linear-gradient(135deg, #bdc3c7, #95a5a6);
            color: white;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
        }

        .student-rank-3 {
            background: linear-gradient(135deg, #e67e22, #d35400);
            color: white;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
        }

        .data-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .data-table thead th {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .data-table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .print-btn {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .print-btn:hover {
            background: var(--primary);
            color: white;
        }

        .export-btn {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .nav-tabs-custom {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 25px;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 25px;
            margin-right: 5px;
            border-radius: 50px 50px 0 0;
            transition: all 0.3s;
        }

        .nav-tabs-custom .nav-link:hover {
            color: var(--secondary);
            background: rgba(52, 152, 219, 0.1);
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--secondary);
            background: white;
            border-bottom: 3px solid var(--secondary);
        }

        .progress {
            height: 10px;
            border-radius: 5px;
            margin-top: 8px;
        }

        .progress-bar-success {
            background: linear-gradient(90deg, #27ae60, #2ecc71);
        }

        .progress-bar-danger {
            background: linear-gradient(90deg, #e74c3c, #c0392b);
        }
    </style>
@endsection

@section('content')
    <div class="side-app">
        <div class="container-fluid">

            {{-- Report Header --}}
            <div class="report-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-5 fw-bold mb-3">
                            <i class="fas fa-chart-pie me-3"></i>Academic Analytics Report
                        </h1>
                        <p class="lead mb-2">
                            <i class="fas fa-calendar-alt me-2"></i>{{ $year }} Academic Year
                        </p>
                        <p class="mb-0 opacity-90">
                            <i class="fas fa-school me-2"></i>{{ $schoolName }}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="mb-3">
                            <span class="badge bg-white text-dark p-3 me-2">
                                <i class="fas fa-file-pdf text-danger me-1"></i> Generated: {{ date('d M Y H:i') }}
                            </span>
                        </div>
                        <button class="print-btn me-2" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                        <button class="export-btn" onclick="exportAllTables()">
                            <i class="fas fa-file-excel me-2"></i>Export All
                        </button>
                    </div>
                </div>
            </div>

            {{-- Quick Stats Cards --}}
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                            <i class="fas fa-school"></i>
                        </div>
                        <h6 class="text-muted mb-2">Total Schools</h6>
                        <h2 class="mb-0">{{ count($schoolRegistration) }}</h2>
                        <small class="text-success">
                            <i
                                class="fas fa-arrow-up me-1"></i>{{ $registrationStats['idaad_count'] + $registrationStats['thanawi_count'] }}
                            students
                        </small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #27ae60, #229954);">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h6 class="text-muted mb-2">Total Students</h6>
                        <h2 class="mb-0">{{ $registrationStats['total_students'] }}</h2>
                        <small>
                            <span class="text-primary">ID: {{ $registrationStats['idaad_count'] }}</span> |
                            <span class="text-success">TH: {{ $registrationStats['thanawi_count'] }}</span>
                        </small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h6 class="text-muted mb-2">Overall Pass Rate</h6>
                        <h2 class="mb-0">{{ $passFailStats['total']['pass'] }}</h2>
                        <small class="text-success">
                            {{ round(($passFailStats['total']['pass'] / max($registrationStats['total_students'], 1)) * 100, 1) }}%
                            passed
                        </small>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h6 class="text-muted mb-2">Overall Fail Rate</h6>
                        <h2 class="mb-0">{{ $passFailStats['total']['fail'] }}</h2>
                        <small class="text-danger">
                            {{ round(($passFailStats['total']['fail'] / max($registrationStats['total_students'], 1)) * 100, 1) }}%
                            failed
                        </small>
                    </div>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <ul class="nav nav-tabs-custom" id="analyticsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                        type="button">
                        <i class="fas fa-chart-simple me-2"></i>Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="schools-tab" data-bs-toggle="tab" data-bs-target="#schools" type="button">
                        <i class="fas fa-school me-2"></i>Schools Registration
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students"
                        type="button">
                        <i class="fas fa-users me-2"></i>Top Students
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects"
                        type="button">
                        <i class="fas fa-book me-2"></i>Subject Analysis
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="performance-tab" data-bs-toggle="tab" data-bs-target="#performance"
                        type="button">
                        <i class="fas fa-chart-line me-2"></i>School Performance
                    </button>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content" id="analyticsTabsContent">

                {{-- Overview Tab --}}
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row">
                        {{-- School Registration Summary --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white border-0 pt-4">
                                    <h5 class="section-title mb-0">
                                        <i class="fas fa-flag me-2 text-primary"></i>School Registration Summary
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>School</th>
                                                    <th class="text-center">Idaad (0)</th>
                                                    <th class="text-center">Thanawi (A)</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (array_slice($schoolRegistration, 0, 5) as $school)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $school['school_name'] }}</strong>
                                                            <br><small
                                                                class="text-muted">{{ $school['school_code'] }}</small>
                                                        </td>
                                                        <td class="text-center">{{ $school['idaad'] }}</td>
                                                        <td class="text-center">{{ $school['thanawi'] }}</td>
                                                        <td class="text-center"><span
                                                                class="badge bg-primary">{{ $school['total'] }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-light fw-bold">
                                                <tr>
                                                    <td>Totals</td>
                                                    <td class="text-center">
                                                        {{ array_sum(array_column($schoolRegistration, 'idaad')) }}</td>
                                                    <td class="text-center">
                                                        {{ array_sum(array_column($schoolRegistration, 'thanawi')) }}</td>
                                                    <td class="text-center">
                                                        {{ array_sum(array_column($schoolRegistration, 'total')) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pass/Fail Overview --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white border-0 pt-4">
                                    <h5 class="section-title mb-0">
                                        <i class="fas fa-percent me-2 text-success"></i>Pass/Fail Analysis
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <div class="badge-pass text-center p-3 w-100">
                                                <h3 class="mb-0">{{ $passFailPercentages['idaad']['pass_percentage'] }}%
                                                </h3>
                                                <small>Idaad Pass Rate</small>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar progress-bar-success"
                                                        style="width: {{ $passFailPercentages['idaad']['pass_percentage'] }}%">
                                                    </div>
                                                </div>
                                                <small>{{ $passFailPercentages['idaad']['pass_count'] }}/{{ $passFailPercentages['idaad']['total'] }}
                                                    students</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="badge-pass text-center p-3 w-100">
                                                <h3 class="mb-0">
                                                    {{ $passFailPercentages['thanawi']['pass_percentage'] }}%</h3>
                                                <small>Thanawi Pass Rate</small>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar progress-bar-success"
                                                        style="width: {{ $passFailPercentages['thanawi']['pass_percentage'] }}%">
                                                    </div>
                                                </div>
                                                <small>{{ $passFailPercentages['thanawi']['pass_count'] }}/{{ $passFailPercentages['thanawi']['total'] }}
                                                    students</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="badge-fail text-center p-3 w-100">
                                                <h4 class="mb-0">{{ $passFailPercentages['idaad']['fail_percentage'] }}%
                                                </h4>
                                                <small>Idaad Fail Rate</small>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar progress-bar-danger"
                                                        style="width: {{ $passFailPercentages['idaad']['fail_percentage'] }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="badge-fail text-center p-3 w-100">
                                                <h4 class="mb-0">
                                                    {{ $passFailPercentages['thanawi']['fail_percentage'] }}%</h4>
                                                <small>Thanawi Fail Rate</small>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar progress-bar-danger"
                                                        style="width: {{ $passFailPercentages['thanawi']['fail_percentage'] }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Schools Registration Tab --}}
                <div class="tab-pane fade" id="schools" role="tabpanel">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                            <h5 class="section-title mb-0">
                                <i class="fas fa-school me-2 text-primary"></i>Schools Registration ({{ $year }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover data-table" id="schoolsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Code</th>
                                            <th>School Name</th>
                                            <th class="text-center">Idaad (0 Level)</th>
                                            <th class="text-center">Thanawi (A Level)</th>
                                            <th class="text-center">Total Students</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schoolRegistration as $index => $school)
                                            <tr>
                                                <td>{{ (int) $index + 1 }}</td>
                                                <td><strong>{{ $school['school_code'] }}</strong></td>
                                                <td>{{ $school['school_name'] }}</td>
                                                <td class="text-center"><span
                                                        class="badge bg-info">{{ $school['idaad'] }}</span></td>
                                                <td class="text-center"><span
                                                        class="badge bg-success">{{ $school['thanawi'] }}</span></td>
                                                <td class="text-center"><span
                                                        class="badge bg-primary">{{ $school['total'] }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light fw-bold">
                                        <tr>
                                            <td colspan="3">Grand Totals</td>
                                            <td class="text-center">
                                                {{ array_sum(array_column($schoolRegistration, 'idaad')) }}</td>
                                            <td class="text-center">
                                                {{ array_sum(array_column($schoolRegistration, 'thanawi')) }}</td>
                                            <td class="text-center">
                                                {{ array_sum(array_column($schoolRegistration, 'total')) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top Students Tab --}}
                <div class="tab-pane fade" id="students" role="tabpanel">
                    <div class="row">
                        {{-- Top 10 Overall --}}
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-header bg-warning text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Top 10 Students (Overall)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Student ID</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($topTenOverall as $index => $student)
                                                    <tr>
                                                        <td>
                                                            @if ($index == 0)
                                                                <span class="student-rank-1">🥇 1st</span>
                                                            @elseif($index == 1)
                                                                <span class="student-rank-2">🥈 2nd</span>
                                                            @elseif($index == 2)
                                                                <span class="student-rank-3">🥉 3rd</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-secondary">{{ (int) $index + 1 }}th</span>
                                                            @endif
                                                        </td>
                                                        <td><small>{{ $student['student_id'] }}</small></td>
                                                        <td><span
                                                                class="badge bg-success">{{ $student['percentage'] }}%</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Top 10 Thanawi (A Level) --}}
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-header bg-success text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Top 10 Thanawi (A Level)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Student ID</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($topTenThanawi as $index => $student)
                                                    <tr>
                                                        <td><span class="badge bg-secondary">{{ (int) $index + 1 }}</span>
                                                        </td>
                                                        <td><small>{{ $student['student_id'] }}</small></td>
                                                        <td><span
                                                                class="badge bg-success">{{ $student['percentage'] }}%</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Top 10 Idaad (O Level) --}}
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-header bg-info text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-school me-2"></i>Top 10 Idaad (O Level)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Student ID</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($topTenIdaad as $index => $student)
                                                    <tr>
                                                        <td><span class="badge bg-secondary">{{ (int) $index + 1 }}</span>
                                                        </td>
                                                        <td><small>{{ $student['student_id'] }}</small></td>
                                                        <td><span
                                                                class="badge bg-success">{{ $student['percentage'] }}%</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subject Analysis Tab --}}
                <div class="tab-pane fade" id="subjects" role="tabpanel">
                    <div class="row">
                        {{-- Best Subjects A Level --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-success text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Best 10 Subjects - A Level
                                        (Thanawi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Subject</th>
                                                    <th class="text-center">Average</th>
                                                    <th class="text-center">Students</th>
                                                    <th class="text-center">Max</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bestSubjects['thanawi'] as $index => $subject)
                                                    <tr>
                                                        <td>{{ (int) $index + 1 }}</td>
                                                        <td>{{ $subject['subject_name'] }}</td>
                                                        <td class="text-center"><span
                                                                class="badge bg-success">{{ $subject['average'] }}%</span>
                                                        </td>
                                                        <td class="text-center">{{ $subject['students_count'] }}</td>
                                                        <td class="text-center">{{ $subject['max'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Best Subjects O Level --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-info text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Best 10 Subjects - O Level (Idaad)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Subject</th>
                                                    <th class="text-center">Average</th>
                                                    <th class="text-center">Students</th>
                                                    <th class="text-center">Max</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bestSubjects['idaad'] as $index => $subject)
                                                    <tr>
                                                        <td>{{ (int) $index + 1 }}</td>
                                                        <td>{{ $subject['subject_name'] }}</td>
                                                        <td class="text-center"><span
                                                                class="badge bg-success">{{ $subject['average'] }}%</span>
                                                        </td>
                                                        <td class="text-center">{{ $subject['students_count'] }}</td>
                                                        <td class="text-center">{{ $subject['max'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Worst Subjects A Level --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-danger text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>5 Worst Subjects -
                                        A Level (Thanawi)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Subject</th>
                                                    <th class="text-center">Average</th>
                                                    <th class="text-center">Students</th>
                                                    <th class="text-center">Min</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($worstSubjects['thanawi'] as $index => $subject)
                                                    <tr>
                                                        <td>{{ (int) $index + 1 }}</td>
                                                        <td>{{ $subject['subject_name'] }}</td>
                                                        <td class="text-center"><span
                                                                class="badge bg-danger">{{ $subject['average'] }}%</span>
                                                        </td>
                                                        <td class="text-center">{{ $subject['students_count'] }}</td>
                                                        <td class="text-center">{{ $subject['min'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Worst Subjects O Level --}}
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-warning text-white rounded-top-4">
                                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>5 Worst Subjects -
                                        O Level (Idaad)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Subject</th>
                                                    <th class="text-center">Average</th>
                                                    <th class="text-center">Students</th>
                                                    <th class="text-center">Min</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($worstSubjects['idaad'] as $index => $subject)
                                                    <tr>
                                                        <td>{{ (int) $index + 1 }}</td>
                                                        <td>{{ $subject['subject_name'] }}</td>
                                                        <td class="text-center"><span
                                                                class="badge bg-warning">{{ $subject['average'] }}%</span>
                                                        </td>
                                                        <td class="text-center">{{ $subject['students_count'] }}</td>
                                                        <td class="text-center">{{ $subject['min'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- School Performance Tab --}}
                <div class="tab-pane fade" id="performance" role="tabpanel">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-0 pt-4">
                            <h5 class="section-title mb-0">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>General Performance - Idaad (O Level) by
                                School
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover data-table" id="performanceTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School Name</th>
                                            <th class="text-center">Total Students</th>
                                            <th class="text-center">1st Class</th>
                                            <th class="text-center">2nd Class Upper</th>
                                            <th class="text-center">2nd Class Lower</th>
                                            <th class="text-center">3rd Class</th>
                                            <th class="text-center">Fail</th>
                                            <th class="text-center">Pass %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schoolPerformance as $index => $school)
                                            <tr>
                                                <td>{{ (int) $index + 1 }}</td>
                                                <td><strong>{{ $school['school_name'] }}</strong></td>
                                                <td class="text-center">{{ $school['total_students'] }}</td>
                                                <td class="text-center"><span
                                                        class="badge bg-success">{{ $school['first_class'] }}</span></td>
                                                <td class="text-center"><span
                                                        class="badge bg-info">{{ $school['second_class_upper'] }}</span>
                                                </td>
                                                <td class="text-center"><span
                                                        class="badge bg-primary">{{ $school['second_class_lower'] }}</span>
                                                </td>
                                                <td class="text-center"><span
                                                        class="badge bg-warning">{{ $school['third_class'] }}</span></td>
                                                <td class="text-center"><span
                                                        class="badge bg-danger">{{ $school['fail'] }}</span></td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $school['pass_percent'] }}%</span>
                                                        <div class="progress flex-grow-1" style="height: 6px;">
                                                            <div class="progress-bar bg-success"
                                                                style="width: {{ $school['pass_percent'] }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="row mt-4 mb-5">
                <div class="col-12 text-center">
                    <a href="{{ route('iteb.analytics.dashboard') }}" class="btn btn-secondary btn-lg px-5">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('iteb.grading.summary') }}" class="btn btn-primary btn-lg px-5 ms-2">
                        <i class="fas fa-calculator me-2"></i>Go to Grading
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            if (!$.fn.DataTable.isDataTable('#schoolsTable')) {
                $('#schoolsTable').DataTable({
                    pageLength: 10,
                    order: [
                        [5, 'desc']
                    ],
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: 'btn btn-success btn-sm',
                            title: 'Schools_Registration_{{ $year }}'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print me-1"></i>Print',
                            className: 'btn btn-info btn-sm',
                            title: 'Schools Registration - {{ $year }}'
                        }
                    ]
                });
            }

            if (!$.fn.DataTable.isDataTable('#performanceTable')) {
                $('#performanceTable').DataTable({
                    pageLength: 10,
                    order: [
                        [2, 'desc']
                    ],
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: 'btn btn-success btn-sm',
                            title: 'School_Performance_Idaad_{{ $year }}'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print me-1"></i>Print',
                            className: 'btn btn-info btn-sm',
                            title: 'School Performance - Idaad (O Level) - {{ $year }}'
                        }
                    ]
                });
            }
        });

        // Export all tables to Excel
        window.exportAllTables = function() {
            Swal.fire({
                title: 'Exporting Data',
                html: 'Preparing Excel file...',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Simulate export preparation
            setTimeout(() => {
                if ($.fn.DataTable.isDataTable('#schoolsTable')) {
                    $('#schoolsTable').DataTable().button('.buttons-excel').trigger();
                }
                Swal.close();

                Swal.fire({
                    icon: 'success',
                    title: 'Export Started',
                    text: 'Your Excel file is being generated.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, 1000);
        }
    </script>
@endsection
