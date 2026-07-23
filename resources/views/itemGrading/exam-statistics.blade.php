@extends('layouts-side-bar.master')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

@section('content')
    <?php use App\Http\Controllers\Helper; ?>

    <style>
        :root {
            --primary-green: #287C44;
            --dark-green: #026837;
            --deep-green: #026837;
            --muted-green: #026837;
            --light-green: #3a9b5a;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            --hover-shadow: 0 20px 30px -10px rgba(40, 124, 68, 0.15);
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--bg-light);
            color: var(--text-dark);
        }

        .side-app {
            padding: 2rem;
            min-height: 100vh;
        }

        .stats-container {
            max-width: 1600px;
            margin: 0 auto;
        }

        .section-wrapper {
            margin-bottom: 2rem;
        }

        .modern-card {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--border-light);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .modern-card:hover {
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-green);
        }

        .modern-card .card-header {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            padding: 1.25rem 2rem;
            border-bottom: none;
        }

        .modern-card .card-header h4,
        .modern-card .card-header h6 {
            color: white;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
            letter-spacing: 0.02em;
        }

        .modern-card .card-header h4 i,
        .modern-card .card-header h6 i {
            color: rgba(255, 255, 255, 0.9);
        }

        .modern-card .card-body {
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--light-green));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-green);
            box-shadow: var(--hover-shadow);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
            background: rgba(40, 124, 68, 0.1);
            color: var(--primary-green);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }

        .stat-trend {
            color: var(--text-muted);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-wrapper {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .filter-label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .modern-select {
            background: white;
            border: 1px solid var(--border-light);
            color: var(--text-dark);
            padding: 0.75rem 1rem;
            border-radius: 14px;
            width: 100%;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modern-select:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(40, 124, 68, 0.1);
        }

        .modern-select option {
            background: white;
            color: var(--text-dark);
        }

        .btn-primary-green {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 14px;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(40, 124, 68, 0.2);
        }

        .btn-primary-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(40, 124, 68, 0.3);
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
        }

        .table-responsive {
            border-radius: 16px;
            overflow: hidden;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
        }

        .modern-table thead th {
            background: #f8fafc;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid var(--border-light);
            white-space: nowrap;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-light);
        }

        .modern-table tbody tr:hover {
            background: rgba(40, 124, 68, 0.02);
        }

        .modern-table tbody td {
            padding: 1.25rem 1.5rem;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-light);
        }

        .modern-badge {
            padding: 0.4rem 1rem;
            border-radius: 100px;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            white-space: nowrap;
        }

        .modern-badge.success {
            background: rgba(40, 124, 68, 0.1);
            color: var(--primary-green);
            border: 1px solid rgba(40, 124, 68, 0.2);
        }

        .modern-badge.danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }

        .modern-badge.warning {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fef3c7;
        }

        .modern-badge.info {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
        }

        .rank-star {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .rank-star.gold {
            background: #fbbf24;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .rank-star.silver {
            background: #e2e8f0;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .rank-star.bronze {
            background: #d97706;
            color: #fffbeb;
            border: 1px solid #b45309;
        }

        .rank-star.default {
            background: #f1f5f9;
            color: var(--text-dark);
            border: 1px solid var(--border-light);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 2rem 0 1.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-left: 0.5rem;
            border-left: 4px solid var(--primary-green);
        }

        .section-title i {
            color: var(--primary-green);
            font-size: 1.1rem;
        }

        .export-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            border: 1px solid var(--border-light);
            background: white;
            color: var(--text-muted);
        }

        .export-btn:hover {
            border-color: var(--primary-green);
            color: var(--primary-green);
            background: rgba(40, 124, 68, 0.02);
            transform: translateY(-1px);
        }

        .gradient-text-green {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .subject-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 992px) {

            .summary-grid,
            .subject-grid {
                grid-template-columns: 1fr;
            }

            .side-app {
                padding: 1rem;
            }
        }

        th {
            background-color: var(--primary-green) !important;
            color: white;
        }

        .school-performance-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            font-size: 0.9rem;
        }

        .school-performance-table th {
            background: var(--primary-green);
            color: white;
            font-weight: 600;
            padding: 1rem 0.5rem;
            text-align: center;
            vertical-align: bottom;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
        }

        .school-performance-table th:last-child {
            border-right: none;
        }

        .school-performance-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
            text-align: center;
        }

        .school-performance-table .grade-header {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            height: 100px;
            white-space: nowrap;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            font-weight: 500;
            line-height: 1.2;
        }

        .school-performance-table .school-name-cell {
            text-align: left;
            font-weight: 600;
        }

        .grade-count-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1rem;
            min-width: 40px;
        }

        .grade-count-badge.first-class {
            background: #fbbf24;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .grade-count-badge.second-upper {
            background: #a7f3d0;
            color: #065f46;
            border: 1px solid #059669;
        }

        .grade-count-badge.second-lower {
            background: #bfdbfe;
            color: #1e40af;
            border: 1px solid #3b82f6;
        }

        .grade-count-badge.third-class {
            background: #fed7aa;
            color: #9a3412;
            border: 1px solid #f97316;
        }

        .grade-count-badge.fail {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #ef4444;
        }

        .school-rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            margin: 0 auto;
        }

        .school-rank-badge.gold {
            background: #fbbf24;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .school-rank-badge.silver {
            background: #e2e8f0;
            color: #475569;
            border: 1px solid #94a3b8;
        }

        .school-rank-badge.bronze {
            background: #d97706;
            color: #fffbeb;
            border: 1px solid #b45309;
        }

        .average-cell {
            font-weight: 700;
            color: var(--primary-green);
        }

        .pass-rate-cell {
            font-weight: 600;
        }

        .section-title.d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title .export-btn {
            background: white;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .section-title .export-btn:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 124, 68, 0.2);
        }

        @media (max-width: 768px) {
            .section-title.d-flex {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-title .export-btn {
                width: 100%;
                justify-content: center;
            }
        }

        .school-performance-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 0.9rem;
            margin: 0;
        }

        .school-performance-table th {
            background: var(--primary-green);
            color: white;
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: center;
            vertical-align: middle;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
            font-size: 0.85rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .school-performance-table th:last-child {
            border-right: none;
        }

        .school-performance-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
            text-align: center;
            color: var(--text-dark);
        }

        .school-performance-table tbody tr {
            transition: all 0.2s ease;
        }

        .school-performance-table tbody tr:hover {
            background: rgba(40, 124, 68, 0.02);
        }

        .school-performance-table .grade-header {
            writing-mode: horizontal-tb;
            transform: none;
            height: auto;
            white-space: normal;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
            font-weight: 500;
            line-height: 1.3;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 70px;
        }

        .school-performance-table .grade-header small {
            font-size: 0.7rem;
            opacity: 0.9;
            font-weight: 400;
            margin-top: 2px;
        }

        .school-performance-table .school-name-cell {
            text-align: left;
            font-weight: 600;
            padding-left: 1.25rem;
        }

        .school-performance-table .school-name-cell .fw-bold {
            color: var(--text-dark);
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .school-performance-table .school-name-cell small {
            color: var(--text-muted);
            font-size: 0.8rem;
        }


        .grade-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            padding: 0.5rem 0.8rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .grade-count-badge.first-class {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #78350f;
            border: 1px solid #f59e0b;
        }

        .grade-count-badge.second-upper {
            background: linear-gradient(135deg, #a7f3d0, #6ee7b7);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .grade-count-badge.second-lower {
            background: linear-gradient(135deg, #bfdbfe, #93c5fd);
            color: #1e3a8a;
            border: 1px solid #3b82f6;
        }

        .grade-count-badge.third-class {
            background: linear-gradient(135deg, #fed7aa, #fdba74);
            color: #9a3412;
            border: 1px solid #f97316;
        }

        .grade-count-badge.fail {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .school-rank-badge {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .school-rank-badge:hover {
            transform: scale(1.1);
        }

        .school-rank-badge.gold {
            background: linear-gradient(135deg, #fbbf24, #d97706);
            color: #78350f;
            border: 1px solid #f59e0b;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
        }

        .school-rank-badge.silver {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            color: #1e293b;
            border: 1px solid #94a3b8;
            box-shadow: 0 4px 10px rgba(100, 116, 139, 0.15);
        }

        .school-rank-badge.bronze {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: #fffbeb;
            border: 1px solid #b45309;
            box-shadow: 0 4px 10px rgba(180, 83, 9, 0.2);
        }

        .school-rank-badge.default {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            color: var(--text-dark);
            border: 1px solid var(--border-light);
        }

        .average-cell {
            font-weight: 700;
            color: var(--primary-green);
            font-size: 1rem;
        }

        .school-performance-table .modern-badge {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            min-width: 70px;
            justify-content: center;
        }

        .school-performance-table .text-muted {
            color: #94a3b8 !important;
            font-weight: 400;
        }

        @media (max-width: 1200px) {
            .school-performance-table {
                font-size: 0.8rem;
            }

            .school-performance-table th,
            .school-performance-table td {
                padding: 0.875rem 0.5rem;
            }

            .grade-count-badge {
                min-width: 40px;
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
            }
        }


        .school-performance-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }

        .school-performance-table tbody tr:nth-child(even):hover {
            background-color: rgba(40, 124, 68, 0.04);
        }

        .modern-card .card-body.p-0 {
            padding: 0 !important;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 0 0 24px 24px;
        }

        .school-performance-table tbody tr:last-child td {
            border-bottom: none;
        }

        .school-performance-table td:first-child {
            font-weight: 600;
        }

        .school-performance-table td:nth-child(3) {
            font-weight: 600;
            color: var(--text-dark);
        }

        .school-performance-table td:nth-child(9) {
            font-weight: 600;
            color: var(--primary-green);
        }

        .school-performance-table td:not(:last-child) {
            border-right: 1px solid var(--border-light);
        }

        .school-performance-table th:not(:last-child) {
            border-right: 2px solid rgba(255, 255, 255, 0.2);
        }

        .school-performance-table thead tr:first-child th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding-top: 1.25rem;
            padding-bottom: 1rem;
        }

        .school-performance-table thead tr:last-child th {
            padding-top: 0.75rem;
            padding-bottom: 1rem;
            font-size: 0.8rem;
        }
    </style>

    <div class="side-app">
        <div class="stats-container">
            <!-- Header Card -->
            <div class="modern-card section-wrapper">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>
                        <i class="fas fa-chart-pie"></i>
                        <span class="gradient-text-white">Exam Statistics Dashboard</span>
                    </h4>
                    <div class="d-flex">
                        <button class="export-btn mr-2" onclick="downloadPdf()">
                            <i class="fas fa-file-pdf"></i>
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-wrapper section-wrapper">
                <form action="{{ route('iteb.exam.statistics') }}" method="POST" id="examStatisticsForm">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="filter-label">
                                <i class="fas fa-calendar-alt me-2" style="color: var(--primary-green);"></i>
                                Year
                            </label>
                            <select name="year" class="modern-select" required>
                                <option value="">Select Year</option>
                                @foreach ($years ?? [] as $y)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">
                                <i class="fas fa-layer-group me-2" style="color: var(--primary-green);"></i>
                                Category
                            </label>
                            <select name="category" id="categorySelect" class="modern-select" required>
                                <option value="">Select Category</option>
                                <option value="UCE" {{ $category == 'UCE' ? 'selected' : '' }}>O-LEVEL (UCE)</option>
                                <!-- <option value="PLE" {{ $category == 'PLE' ? 'selected' : '' }}>Primary (PLE)</option> -->
                                <option value="UACE" {{ $category == 'UACE' ? 'selected' : '' }}>A-LEVEL (UACE)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">
                                <i class="fas fa-signal me-2" style="color: var(--primary-green);"></i>
                                Level
                            </label>
                            <select name="level" id="levelSelect" class="modern-select">
                                <option value="A" {{ $level == 'A' ? 'selected' : '' }}>Advanced Level (A)</option>
                                <option value="O" {{ $level == 'O' ? 'selected' : '' }}>Ordinary Level (O)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">&nbsp;</label>
                            <button type="submit" class="btn-primary-green" id="submitBtn">
                                <span id="btnText">
                                    <i class="fas fa-chart-line"></i>
                                    Fetch Records
                                </span>

                                <span id="btnLoader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Fetching records...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($registeredStudents))
                <!-- Stats Cards -->
                <div class="summary-grid section-wrapper">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-label">Registered Students</div>
                        <div class="stat-value">{{ number_format($registeredStudents) }}</div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up" style="color: var(--primary-green);"></i>
                            Total enrollment
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="color: var(--primary-green);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Graded Students</div>
                        <div class="stat-value">{{ number_format($totalGraded) }}</div>
                        <div class="stat-trend">
                            <i class="fas fa-check" style="color: var(--primary-green);"></i>
                            Successfully graded
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="color: #dc2626;">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="stat-label">Failed Students</div>
                        <div class="stat-value">{{ number_format($failedBreakdown['total_failed']) }}</div>
                        <div class="stat-trend">
                            <i class="fas fa-exclamation-triangle" style="color: #dc2626;"></i>
                            Critical Attention
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($schoolsTable))
                <!-- Schools Section -->
                <div class="modern-card section-wrapper">
                    <div class="card-header">
                        <h6>
                            <i class="fas fa-school me-2"></i>
                            Registered Schools - {{ $year }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th width="80">#</th>
                                        <th>Level</th>
                                        <th>Number of School</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $levelCode = strpos($levelName, 'UACE') !== false ? 'UACE' : 'UCE';

                                        $schools = DB::table('class_allocation')
                                            ->select(DB::raw("DISTINCT SUBSTRING_INDEX(Student_ID, '-', 2) as center_code"))
                                            ->where('Student_ID', 'like', "%-$levelCode-%")
                                            ->where('Student_ID', 'like', "%-$year")
                                            ->get();

                                        $schoolCount = $schools->count();
                                    @endphp
                                    @foreach ($schoolsTable as $index => $school)
                                        <tr>
                                            <td>
                                                <span class="rank-star default">
                                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </td>
                                            <td>{{ $levelName }}</td>
                                            <td>{{ $schoolCount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Grading Summary -->
                <div class="modern-card section-wrapper">
                    <div class="card-header">
                        <h6>
                            <i class="fas fa-chart-bar me-2"></i>
                            Grading Summary (Passing Grades Only) - {{ $levelName }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Grade</th>
                                        <th class="text-center">Male</th>
                                        <th class="text-center">%</th>
                                        <th class="text-center">Female</th>
                                        <th class="text-center">%</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(['D1' => 'Excellent D1', 'D2' => 'Very Good D2', 'C3' => 'Good C3', 'C4' => 'Pass C4'] as $key => $label)
                                        <tr>
                                            <td class="fw-bold">{{ $label }}</td>
                                            <td class="text-center">{{ $gradingSummary[$key]['male_count'] }}</td>
                                            <td class="text-center">
                                                <span class="modern-badge success">
                                                    {{ $gradingSummary[$key]['male_percent'] }}%
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $gradingSummary[$key]['female_count'] }}</td>
                                            <td class="text-center">
                                                <span class="modern-badge success">
                                                    {{ $gradingSummary[$key]['female_percent'] }}%
                                                </span>
                                            </td>
                                            <td class="text-center fw-bold">{{ $gradingSummary[$key]['total'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="background: #e8f5e9; font-weight: bold;">
                                        <td class="fw-bold">Subtotal (Passing Grades)</td>
                                        <td class="text-center">{{ $totals['male_total'] - $failedBreakdown['male_failed'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="modern-badge success">
                                                {{ $totals['overall_total'] > 0 ? round((($totals['male_total'] - $failedBreakdown['male_failed']) / $totals['overall_total']) * 100, 2) : 0 }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ $totals['female_total'] - $failedBreakdown['female_failed'] }}
                                        </td>
                                        <td class="text-center">
                                            <span class="modern-badge success">
                                                {{ $totals['overall_total'] > 0 ? round((($totals['female_total'] - $failedBreakdown['female_failed']) / $totals['overall_total']) * 100, 2) : 0 }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ $totals['overall_total'] - $failedBreakdown['total_failed'] }}
                                        </td>
                                    </tr>
                                    <tr style="background: #f8fafc;">
                                        <td class="fw-bold">Total (All Students)</td>
                                        <td class="text-center fw-bold">{{ $totals['male_total'] }}</td>
                                        <td class="text-center">
                                            <span class="modern-badge info">
                                                {{ $totals['male_total'] > 0 ? round(($totals['male_total'] / $totals['overall_total']) * 100, 2) : 0 }}%
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">{{ $totals['female_total'] }}</td>
                                        <td class="text-center">
                                            <span class="modern-badge info">
                                                {{ $totals['female_total'] > 0 ? round(($totals['female_total'] / $totals['overall_total']) * 100, 2) : 0 }}%
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">{{ $totals['overall_total'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Failed Students Section -->
                <div class="modern-card section-wrapper">
                    <div class="card-header" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                        <h6>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Students Failed - {{ $levelName }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th class="text-center">Male</th>
                                        <th class="text-center">Female</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Failed Students</td>
                                        <td class="text-center">
                                            <span class="modern-badge danger">{{ $failedBreakdown['male_failed'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="modern-badge danger">{{ $failedBreakdown['female_failed'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="modern-badge danger">{{ $failedBreakdown['total_failed'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Students Section -->
                @if(isset($topStudents) && count($topStudents) > 0)
                    <div class="section-title d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-trophy"></i>
                            Top 10 Students - {{ $levelName }}
                        </div>
                        <button class="export-btn" onclick="downloadStudentsFullReport()">
                            <i class="fas fa-file-pdf"></i>
                            Download Full Report
                        </button>
                    </div>

                    <div class="modern-card section-wrapper">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Rank</th>
                                            <th>Student</th>
                                            <th>School</th>
                                            <th class="text-center">Gender</th>
                                            <th class="text-center">Marks</th>
                                            <th class="text-center">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topStudents as $index => $student)
                                            <tr>
                                                <td class="text-center">
                                                    @if($index == 0)
                                                        <span class="rank-star gold">
                                                            <i class="fas fa-crown"></i>
                                                        </span>
                                                    @elseif($index == 1)
                                                        <span class="rank-star silver">
                                                            2
                                                        </span>
                                                    @elseif($index == 2)
                                                        <span class="rank-star bronze">
                                                            3
                                                        </span>
                                                    @else
                                                        <span class="rank-star default">
                                                            {{ $index + 1 }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-bold">{{ Helper::getStudentName($student['student_id']) }}</div>
                                                    <small class="text-muted">ID: {{ $student['student_id'] }}</small>
                                                </td>
                                                <td>{{ $student['school_name'] }}</td>
                                                <td class="text-center">
                                                    @if(strtolower($student['gender']) == 'male')
                                                        <span class="modern-badge info">
                                                            <i class="fas fa-mars"></i> Male
                                                        </span>
                                                    @else
                                                        <span class="modern-badge danger">
                                                            <i class="fas fa-venus"></i> Female
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center fw-bold">{{ number_format($student['total_marks'], 2) }}</td>
                                                <td class="text-center">
                                                    <span class="modern-badge success">
                                                        {{ number_format($student['percentage'], 2) }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Subject Performance -->
                @if(isset($bestSubjects) && isset($worstSubjects))
                    <div class="section-title">
                        <i class="fas fa-book-open"></i>
                        Subject Performance Analysis
                    </div>

                    <div class="subject-grid section-wrapper">
                        <!-- Best Subjects -->
                        <div class="modern-card">
                            <div class="card-header"
                                style="background: linear-gradient(135deg, var(--primary-green), var(--dark-green));">
                                <h6>
                                    <i class="fas fa-trophy me-2"></i>
                                    Best Performing Subjects
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Subject</th>
                                                <th class="text-center">Average</th>
                                                <th class="text-center">Pass Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bestSubjects as $index => $subject)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="modern-badge success">#{{ $index + 1 }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold">{{ Helper::item_md_name($subject['subject_name']) }}</div>
                                                        <small class="text-muted">{{ $subject['student_count'] }} students</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="modern-badge success">
                                                            {{ number_format($subject['average'], 2) }}%
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="modern-badge info">
                                                            {{ $subject['pass_percentage'] }}%
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Worst Subjects -->
                        <div class="modern-card">
                            <div class="card-header" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                                <h6>
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Worst Done Subjects
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Subject</th>
                                                <th class="text-center">Average</th>
                                                <th class="text-center">Pass Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($worstSubjects as $index => $subject)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="modern-badge danger">#{{ $index + 1 }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold">{{ Helper::item_md_name($subject['subject_name']) }}</div>
                                                        <small class="text-muted">{{ $subject['student_count'] }} students</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="modern-badge warning">
                                                            {{ number_format($subject['average'], 2) }}%
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="modern-badge danger">
                                                            {{ $subject['pass_percentage'] }}%
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif

                <!-- Top Schools Performance -->
                @if(isset($topSchools) && count($topSchools) > 0)
                    <div class="section-title d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-school"></i>
                            Top 10 Best Performing Schools - {{ $levelName }}
                        </div>
                        <button class="export-btn" onclick="downloadSchoolsFullReport()">
                            <i class="fas fa-file-pdf"></i>
                            Download Full Report
                        </button>
                    </div>

                    <div class="modern-card section-wrapper">
                        <div class="card-header" style="background: linear-gradient(135deg, var(--primary-green), #0e5e2c);">
                            <h6>
                                <i class="fas fa-trophy me-2"></i>
                                School Performance Summary
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="school-performance-table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="background: #0e5e2c; width: 60px;">Rank</th>
                                            <th rowspan="2" style="background: #0e5e2c; text-align: left; min-width: 250px;">School
                                            </th>
                                            <th rowspan="2" style="background: #0e5e2c; width: 80px;">Total<br>Std</th>
                                            <th colspan="5" style="background: #0e5e2c; text-align: center;">Grade Distribution</th>
                                            <th rowspan="2" style="background: #0e5e2c; width: 70px;">Graded</th>
                                            <th rowspan="2" style="background: #0e5e2c; width: 80px;">Average<br>%</th>
                                            <th rowspan="2" style="background: #0e5e2c; width: 80px;">Pass<br>Rate</th>
                                        </tr>
                                        <tr>
                                            <th style="background: #0e5e2c;" class="grade-column">
                                                <div class="grade-header">FIRST CLASS<br><small>ممتاز</small></div>
                                            </th>
                                            <th style="background: #0e5e2c;" class="grade-column">
                                                <div class="grade-header">SECOND UPPER<br><small>جيد جدا</small></div>
                                            </th>
                                            <th style="background: #0e5e2c;" class="grade-column">
                                                <div class="grade-header">SECOND LOWER<br><small>جيد</small></div>
                                            </th>
                                            <th style="background: #0e5e2c;" class="grade-column">
                                                <div class="grade-header">THIRD CLASS<br><small>مقبول</small></div>
                                            </th>
                                            <th style="background: #0e5e2c;" class="grade-column">
                                                <div class="grade-header">FAIL<br><small>راسب</small></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topSchools as $index => $school)
                                            <tr>
                                                <td>
                                                    <div class="school-rank-badge 
                                                                                        @if($index == 0) gold
                                                                                        @elseif($index == 1) silver
                                                                                        @elseif($index == 2) bronze
                                                                                        @endif">
                                                        @if($index == 0)
                                                            <i class="fas fa-crown"></i>
                                                        @else
                                                            {{ $index + 1 }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="school-name-cell">
                                                    <div class="fw-bold">{{ $school['school_name'] }}</div>
                                                    <small class="text-muted">{{ $school['school_code'] }}</small>
                                                </td>
                                                <td class="fw-bold">{{ $school['total_students'] }}</td>

                                                <!-- First Class -->
                                                <td>
                                                    @if($school['grades']['FIRST CLASS'] > 0)
                                                        <span class="grade-count-badge first-class">
                                                            {{ $school['grades']['FIRST CLASS'] }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <!-- Second Upper -->
                                                <td>
                                                    @if($school['grades']['SECOND CLASS UPPER'] > 0)
                                                        <span class="grade-count-badge second-upper">
                                                            {{ $school['grades']['SECOND CLASS UPPER'] }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <!-- Second Lower -->
                                                <td>
                                                    @if($school['grades']['SECOND CLASS LOWER'] > 0)
                                                        <span class="grade-count-badge second-lower">
                                                            {{ $school['grades']['SECOND CLASS LOWER'] }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <!-- Third Class -->
                                                <td>
                                                    @if($school['grades']['THIRD CLASS'] > 0)
                                                        <span class="grade-count-badge third-class">
                                                            {{ $school['grades']['THIRD CLASS'] }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <!-- Fail -->
                                                <td>
                                                    @if($school['grades']['FAIL'] > 0)
                                                        <span class="grade-count-badge fail">
                                                            {{ $school['grades']['FAIL'] }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <td class="fw-bold">{{ $school['graded_students'] }}</td>
                                                <td class="average-cell">{{ number_format($school['average_percentage'], 2) }}%</td>
                                                <td>
                                                    @php
                                                        $passRateClass = $school['pass_rate'] >= 70 ? 'success' :
                                                            ($school['pass_rate'] >= 50 ? 'warning' : 'danger');
                                                    @endphp
                                                    <span class="modern-badge {{ $passRateClass }}">
                                                        {{ number_format($school['pass_rate'], 2) }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>


    <!-- Keep existing scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('examStatisticsForm').addEventListener('submit', function () {

            const button = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');

            // Disable button
            button.disabled = true;
            button.style.opacity = "0.7";
            button.style.cursor = "not-allowed";

            // Swap text with loader
            btnText.style.display = "none";
            btnLoader.style.display = "inline-block";
        });
    </script>

    <script>
        // Your existing JavaScript functions here
        function showMissingResourcesAlert() {
            Swal.fire({
                icon: 'error',
                title: 'Missing Required Resources',
                text: 'Some required resources are missing. Please update Server',
                confirmButtonColor: '#287C44',
                confirmButtonText: 'OK'
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const category = document.getElementById('categorySelect');
            const level = document.getElementById('levelSelect');

            function setLevelBasedOnCategory() {
                if (category.value === 'ID') {
                    level.value = 'O';
                } else if (category.value === 'TH') {
                    level.value = 'A';
                } else if (category.value === 'PLE') {
                    level.value = 'P';
                }
                level.disabled = true;
            }

            category.addEventListener('change', setLevelBasedOnCategory);
            setLevelBasedOnCategory();
        });

        function downloadPdf() {
            downloadFile('pdf');
        }

        function downloadFile(type) {
            const year = $('select[name="year"]').val();
            const category = $('select[name="category"]').val();
            const level = $('select[name="level"]').val();

            if (!year || !category) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    text: 'Please select Year and Category before downloading.',
                    confirmButtonColor: '#287C44'
                });
                return;
            }

            const route = type === 'excel'
                ? '{{ route("iteb.exam.statistics.download.excel") }}'
                : '{{ route("iteb.exam.statistics.download.pdf") }}';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = route;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            const yearInput = document.createElement('input');
            yearInput.type = 'hidden';
            yearInput.name = 'year';
            yearInput.value = year;
            form.appendChild(yearInput);

            const categoryInput = document.createElement('input');
            categoryInput.type = 'hidden';
            categoryInput.name = 'category';
            categoryInput.value = category;
            form.appendChild(categoryInput);

            const levelInput = document.createElement('input');
            levelInput.type = 'hidden';
            levelInput.name = 'level';
            levelInput.value = level;
            form.appendChild(levelInput);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            Swal.fire({
                title: `Generating ${type.toUpperCase()}...`,
                text: 'Your file will be downloaded shortly.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                Swal.close();
            }, 3000);
        }
    </script>

    <script>
        function downloadStudentsFullReport() {
            downloadReport('students', 'full');
        }

        function downloadSchoolsFullReport() {
            downloadReport('schools', 'full');
        }

        function downloadReport(reportType, reportScope) {
            const year = $('select[name="year"]').val();
            const category = $('select[name="category"]').val();
            const level = $('select[name="level"]').val();

            if (!year || !category) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    text: 'Please select Year and Category before downloading.',
                    confirmButtonColor: '#287C44'
                });
                return;
            }

            Swal.fire({
                title: `Generating ${reportType} report...`,
                text: 'This may take a moment for large datasets.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const route = reportType === 'students'
                ? '{{ route("iteb.exam.statistics.download.students") }}'
                : '{{ route("iteb.exam.statistics.download.schools") }}';

            // Create a hidden form and submit
            const form = $('<form>', {
                'method': 'POST',
                'action': route,
                'target': '_blank'
            });

            form.append($('<input>', {
                'name': '_token',
                'value': '{{ csrf_token() }}',
                'type': 'hidden'
            }));

            form.append($('<input>', {
                'name': 'year',
                'value': year,
                'type': 'hidden'
            }));

            form.append($('<input>', {
                'name': 'category',
                'value': category,
                'type': 'hidden'
            }));

            form.append($('<input>', {
                'name': 'level',
                'value': level,
                'type': 'hidden'
            }));

            $('body').append(form);
            form.submit();
            form.remove();

            // Close the loading message after a delay
            setTimeout(() => {
                Swal.close();
            }, 4000);
        }
    </script>
@endsection