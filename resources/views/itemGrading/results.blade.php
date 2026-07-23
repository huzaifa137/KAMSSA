@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container mt-4">

            <style>
                .subject-tabs-wrapper {
                    margin-bottom: 25px;
                    padding: 10px 15px;
                    background: transparent;
                }

                .subject-tabs {
                    display: flex;
                    flex-wrap: nowrap;
                    overflow-x: auto;
                    overflow-y: hidden;
                    scrollbar-width: thin;
                    padding: 5px 0 15px 0;
                    gap: 12px;
                    scroll-behavior: smooth;
                }

                .subject-tabs::-webkit-scrollbar {
                    height: 6px;
                }

                .subject-tabs::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }

                .subject-tabs::-webkit-scrollbar-thumb {
                    background: #287C44;
                    border-radius: 10px;
                }

                .subject-tabs::-webkit-scrollbar-thumb:hover {
                    background: #1e5f33;
                }

                .subject-tab {
                    padding: 18px 25px;
                    background-color: #ffffff;
                    border: 1px solid #e0e0e0;
                    border-radius: 16px;
                    cursor: pointer;
                    font-weight: 600;
                    transition: all 0.3s ease;
                    position: relative;
                    min-width: 220px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                    flex: 0 0 auto;
                }

                .subject-tab:hover {
                    background-color: #f0f7f2;
                    border-color: #287C44;
                    transform: translateY(-4px);
                    box-shadow: 0 8px 16px rgba(40, 124, 68, 0.15);
                }

                .subject-tab.active {
                    background-color: #287C44;
                    color: white;
                    border-color: #287C44;
                    box-shadow: 0 8px 20px rgba(40, 124, 68, 0.25);
                    transform: translateY(-2px);
                }

                /* Tab Content Layout */
                .subject-tab .tab-content {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }

                .subject-tab .tab-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    width: 100%;
                    gap: 10px;
                }

                .subject-tab .subject-info {
                    flex: 1;
                }

                .subject-tab .subject-name {
                    font-size: 15px;
                    line-height: 1.4;
                    font-weight: 600;
                    word-break: break-word;
                    white-space: normal;
                    max-width: 180px;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .subject-tab.active .subject-name {
                    color: white;
                }

                /* Progress Bar */
                .subject-progress {
                    height: 8px;
                    background-color: #e9ecef;
                    border-radius: 10px;
                    margin: 8px 0;
                    overflow: hidden;
                    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                }

                .progress-fill {
                    height: 100%;
                    background: linear-gradient(90deg, #28a745, #34ce57);
                    transition: width 0.3s ease;
                    border-radius: 10px;
                }

                /* Stats Row */
                .subject-tab .stats-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    font-size: 12px;
                    font-weight: 500;
                    color: #6c757d;
                    margin-top: 5px;
                    padding-top: 8px;
                    border-top: 1px dashed rgba(0, 0, 0, 0.1);
                }

                .subject-tab.active .stats-row {
                    color: rgba(255, 255, 255, 0.9);
                    border-top: 1px dashed rgba(255, 255, 255, 0.3);
                }

                .subject-tab .stats-row span {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }

                .subject-tab .stats-row i {
                    font-size: 11px;
                }

                .subject-tab .pending-badge {
                    background-color: #dc3545;
                    color: white;
                    padding: 4px 10px;
                    border-radius: 30px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                    box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
                }

                .subject-tab .saved-badge {
                    background-color: #e9ecef;
                    color: #495057;
                    padding: 4px 10px;
                    border-radius: 30px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                }

                .subject-tab.active .saved-badge {
                    background-color: rgba(255, 255, 255, 0.2);
                    color: white;
                }

                /* Tab Status Badge Container - prevents duplicate badges */
                .tab-status-badge {
                    flex-shrink: 0;
                }

                .tab-status-badge .pending-badge,
                .tab-status-badge .saved-badge {
                    white-space: nowrap;
                }

                /* Tab Content Styling */
                .tab-pane {
                    display: none;
                }

                .tab-pane.active {
                    display: block;
                }

                /* Table Styling */
                .mark-input {
                    transition: all 0.2s;
                    min-width: 90px;
                }

                .mark-input.saved {
                    border-color: #28a745;
                    background-color: #f0fff0;
                }

                .mark-input.unsaved {
                    border-color: #ffc107;
                }

                /* Over-max values must always show red, regardless of
                       whether the input also carries .saved/.unsaved */
                .mark-input.is-invalid,
                .mark-input.border-danger {
                    border-color: #dc3545 !important;
                    background-color: #fff5f5 !important;
                    box-shadow: 0 0 0 1px #dc3545 !important;
                }

                /* Keep the table from squishing columns on small screens —
                       let it scroll horizontally instead so every value stays
                       fully readable/editable on any device. */
                .table-responsive table {
                    min-width: 560px;
                }

                /* Save Indicator */
                .save-indicator {
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    margin-left: 5px;
                }

                .save-indicator.saved {
                    background-color: #28a745;
                }

                .save-indicator.unsaved {
                    background-color: #ffc107;
                }

                /* Action Buttons */
                .action-buttons {
                    position: sticky;
                    bottom: 20px;
                    z-index: 1000;
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    padding: 10px;
                    background: rgba(255, 255, 255, 0.95);
                    border-radius: 50px;
                    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
                    margin-top: 20px;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .subject-tab {
                        min-width: 200px;
                        padding: 15px 20px;
                    }

                    .subject-tab .subject-name {
                        font-size: 14px;
                        max-width: 160px;
                    }

                    .action-buttons {
                        flex-direction: column;
                        border-radius: 10px;
                    }

                    .action-buttons button {
                        width: 100%;
                    }
                }

                @media (max-width: 480px) {
                    .subject-tab {
                        min-width: 180px;
                        padding: 12px 15px;
                    }

                    .subject-tab .subject-name {
                        font-size: 13px;
                        max-width: 140px;
                    }
                }

                .card-footer .d-flex {
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .card-footer .d-flex>div {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                }

                .card-footer .d-flex>button {
                    flex-shrink: 0;
                }

                @media (max-width: 576px) {
                    .card-footer .d-flex {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .card-footer .d-flex>div {
                        justify-content: flex-start;
                        width: 100%;
                    }

                    .card-footer .d-flex>button {
                        width: 100%;
                    }
                }

                /* ── Student search bar ── */
                .subject-search-box {
                    position: relative;
                    max-width: 360px;
                }

                .subject-search-box .fa-search {
                    position: absolute;
                    left: 14px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #9aa5a0;
                    font-size: 13px;
                    pointer-events: none;
                }

                .student-search-input {
                    padding-left: 36px !important;
                    padding-right: 34px !important;
                    border-radius: 10px !important;
                    border: 1.5px solid #e2e8e5 !important;
                }

                .student-search-input:focus {
                    border-color: #287C44 !important;
                    box-shadow: 0 0 0 3px rgba(40, 124, 68, 0.12) !important;
                }

                .subject-search-clear {
                    position: absolute;
                    right: 8px;
                    top: 50%;
                    transform: translateY(-50%);
                    border: none;
                    background: #eef1f0;
                    color: #666;
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    font-size: 11px;
                    display: none;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    padding: 0;
                }

                .subject-search-clear:hover {
                    background: #d33;
                    color: #fff;
                }

                /* ── Paper input boxes: force one horizontal row, no wrapping ── */
                /* ── Paper input boxes: force one horizontal row, with visible gaps ── */
                .paper-inputs-group {
                    display: flex !important;
                    flex-wrap: nowrap !important;
                    align-items: flex-end !important;
                }

                .paper-inputs-group>div {
                    box-sizing: border-box;
                    flex: 0 0 80px !important;
                    width: 80px !important;
                    margin-right: 16px !important;
                    padding-right: 0;
                }

                .paper-inputs-group>div:last-child {
                    margin-right: 0 !important;
                }

                .paper-input {
                    width: 100% !important;
                    box-sizing: border-box;
                }

                /* Avg badge box — same width/alignment as paper boxes so it lines up */
                .paper-avg-box {
                    flex: 0 0 auto;
                    width: 80px;
                    display: flex;
                    justify-content: center;
                    padding-bottom: 6px;
                    /* matches the "P1 out of" label height under inputs */
                }

                /* Let the marks column scroll horizontally instead of wrapping when there
       are many papers, so boxes never stack vertically */
                .table-responsive table {
                    min-width: 700px;
                }

                /* ── Student search bar ── */
                .subject-search-box {
                    position: relative;
                    max-width: 420px;
                    width: 100%;
                }

                .subject-search-box .fa-search {
                    position: absolute;
                    left: 14px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #287C44;
                    /* Always green, not gray */
                    font-size: 14px;
                    pointer-events: none;
                    transition: all 0.3s ease;
                    z-index: 2;
                }

                .student-search-input {
                    padding-left: 40px !important;
                    padding-right: 40px !important;
                    border-radius: 12px !important;
                    border: 2px solid #287C44 !important;
                    /* Always green border */
                    background: #ffffff !important;
                    /* Always white */
                    height: 46px !important;
                    font-size: 14px !important;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                    width: 100% !important;
                    box-shadow: 0 0 0 4px rgba(40, 124, 68, 0.12), 0 4px 12px rgba(40, 124, 68, 0.08) !important;
                    /* Always visible glow */
                    color: #1a2e24 !important;
                }

                .student-search-input::placeholder {
                    color: #7a9a8a;
                    font-weight: 400;
                    letter-spacing: 0.3px;
                }

                .student-search-input:hover {
                    background: #ffffff !important;
                    border-color: #1a5c33 !important;
                    box-shadow: 0 0 0 4px rgba(40, 124, 68, 0.18), 0 4px 16px rgba(40, 124, 68, 0.12) !important;
                    transform: translateY(-1px);
                }

                .student-search-input:focus {
                    background: #ffffff !important;
                    border-color: #1a5c33 !important;
                    box-shadow: 0 0 0 5px rgba(40, 124, 68, 0.20), 0 4px 20px rgba(40, 124, 68, 0.15) !important;
                    outline: none !important;
                    transform: translateY(-2px);
                }

                /* Clear button - ALWAYS VISIBLE with enhanced styling */
                .subject-search-clear {
                    position: absolute;
                    right: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    border: none;
                    background: #e8f5ee;
                    color: #287C44;
                    width: 26px;
                    height: 26px;
                    border-radius: 50%;
                    font-size: 13px;
                    display: flex !important;
                    /* Always visible */
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    padding: 0;
                    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                    z-index: 2;
                    box-shadow: 0 2px 4px rgba(40, 124, 68, 0.1);
                }

                .subject-search-clear:hover {
                    background: #dc3545;
                    color: #fff;
                    transform: translateY(-50%) scale(1.15);
                    box-shadow: 0 2px 12px rgba(220, 53, 69, 0.4);
                }

                .subject-search-clear:active {
                    transform: translateY(-50%) scale(0.9);
                }

                /* Search result count badge - ALWAYS VISIBLE */
                .search-result-count {
                    position: absolute;
                    right: 48px;
                    top: 50%;
                    transform: translateY(-50%);
                    font-size: 11px;
                    font-weight: 600;
                    color: #287C44;
                    background: #e8f5ee;
                    padding: 3px 12px;
                    border-radius: 20px;
                    white-space: nowrap;
                    pointer-events: none;
                    z-index: 2;
                    box-shadow: 0 2px 4px rgba(40, 124, 68, 0.08);
                    border: 1px solid rgba(40, 124, 68, 0.15);
                }

                .search-result-count .count-number {
                    color: #1a5c33;
                    font-weight: 700;
                }

                /* Animated underline effect - ALWAYS VISIBLE */
                .subject-search-box::after {
                    content: '';
                    position: absolute;
                    bottom: -3px;
                    left: 0;
                    width: 100%;
                    height: 2px;
                    background: linear-gradient(90deg, #287C44, #34ce57, #287C44);
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    border-radius: 2px;
                    opacity: 1;
                    /* Always visible */
                    background-size: 200% 100%;
                    animation: shimmer 3s ease-in-out infinite;
                }

                @keyframes shimmer {
                    0% {
                        background-position: -200% 0;
                    }

                    100% {
                        background-position: 200% 0;
                    }
                }

                /* Glow pulse animation - ALWAYS VISIBLE */
                .subject-search-box::before {
                    content: '';
                    position: absolute;
                    top: -2px;
                    left: -2px;
                    right: -2px;
                    bottom: -2px;
                    border-radius: 14px;
                    background: linear-gradient(135deg, rgba(40, 124, 68, 0.06), rgba(52, 206, 87, 0.06));
                    z-index: -1;
                    animation: pulseGlow 2s ease-in-out infinite;
                }

                @keyframes pulseGlow {

                    0%,
                    100% {
                        opacity: 0.5;
                        transform: scale(1);
                    }

                    50% {
                        opacity: 1;
                        transform: scale(1.02);
                    }
                }

                /* Responsive adjustments */
                @media (max-width: 768px) {
                    .subject-search-box {
                        max-width: 100%;
                    }

                    .student-search-input {
                        height: 42px !important;
                        font-size: 13px !important;
                        padding-left: 36px !important;
                        padding-right: 36px !important;
                        box-shadow: 0 0 0 3px rgba(40, 124, 68, 0.10), 0 4px 10px rgba(40, 124, 68, 0.06) !important;
                    }

                    .subject-search-clear {
                        width: 22px;
                        height: 22px;
                        font-size: 11px;
                        right: 10px;
                    }

                    .search-result-count {
                        right: 42px;
                        font-size: 10px;
                        padding: 2px 10px;
                    }
                }

                @media (max-width: 480px) {
                    .student-search-input {
                        height: 38px !important;
                        font-size: 12px !important;
                        padding-left: 32px !important;
                        padding-right: 32px !important;
                        border-radius: 10px !important;
                        box-shadow: 0 0 0 2px rgba(40, 124, 68, 0.08), 0 4px 8px rgba(40, 124, 68, 0.04) !important;
                    }

                    .subject-search-box .fa-search {
                        left: 10px;
                        font-size: 12px;
                    }

                    .subject-search-clear {
                        width: 20px;
                        height: 20px;
                        font-size: 10px;
                        right: 8px;
                    }

                    .search-result-count {
                        right: 36px;
                        font-size: 9px;
                        padding: 1px 8px;
                    }
                }

                /* Distinguishes "typed but not yet saved" from "confirmed saved in DB" */
                .mark-input.pending-save {
                    border-color: #0d6efd;
                    background-color: #eef5ff;
                }
            </style>

            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background-color: #026837;">
                    <h4 class="mb-0">
                        <i class="fa fa-school me-2"></i> School NAME - {{ $schoolName ?? 'N/A' }}
                    </h4>
                    <span class="badge bg-light text-dark">
                        <i class="fa fa-users me-1"></i> {{ $records->count() }} Students
                    </span>
                </div>

                <div class="card-body">

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            @if (session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: @json(session('success')),
                                    confirmButtonColor: '#3085d6'
                                });
                            @endif

                            @if ($errors->any())
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: `{!! implode('<br>', $errors->all()) !!}`,
                                    confirmButtonColor: '#d33'
                                });
                            @endif
                        });
                    </script>

                    @if ($records->count() > 0)
                        <!-- Multi-Subject Tabs -->
                        <div class="subject-tabs-wrapper">
                            <div class="subject-tabs" id="subjectTabs">
                                @foreach ($subjects as $index => $subject)
                                    @php
                                        // Use the subject-specific student count from the controller
                                        $subjectStudentIds = $subject->student_ids ?? [];
                                        $subjectStudentCount = count($subjectStudentIds);
                                        
                                        // Count saved marks for this subject (only for students in this subject's roster)
                                        $savedCount = 0;
                                        foreach ($subjectStudentIds as $studentId) {
                                            if (isset($existingMarks[$subject->md_id][$studentId])) {
                                                $savedCount++;
                                            }
                                        }
                                        
                                        $unsavedCount = $subjectStudentCount - $savedCount;
                                        $progressPercent = $subjectStudentCount > 0 ? ($savedCount / $subjectStudentCount) * 100 : 0;
                                        $isComplete = $unsavedCount == 0 && $subjectStudentCount > 0;
                                    @endphp
                                    <div class="subject-tab {{ $index === 0 ? 'active' : '' }}"
                                        data-subject-id="{{ $subject->md_id }}" data-subject-name="{{ $subject->md_name }}">
                                        <div class="tab-content">
                                            <div class="tab-header">
                                                <div class="subject-info">
                                                    <div class="subject-name">{{ $subject->md_name }}</div>
                                                </div>
                                                <div class="tab-status-badge">
                                                    @if ($isComplete)
                                                        <span class="saved-badge">
                                                            <i class="fa fa-check-circle"></i> Complete
                                                        </span>
                                                    @elseif ($unsavedCount > 0)
                                                        <span class="pending-badge">
                                                            <i class="fa fa-clock"></i> {{ $unsavedCount }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="subject-progress">
                                                <div class="progress-fill" style="width: {{ $progressPercent }}%"></div>
                                            </div>

                                            <div class="stats-row">
                                                <span>
                                                    <i class="fa fa-save"></i> {{ $savedCount }}/{{ $subjectStudentCount }}
                                                    saved
                                                </span>
                                                <span>
                                                    <i class="fa fa-percent"></i> {{ round($progressPercent) }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Forms Container -->
                        <div id="formsContainer">
                            @foreach ($subjects as $index => $subject)
                                @php
                                    // Use the subject-specific student IDs passed from controller
                                    $subjectStudentIds = $subject->student_ids ?? [];
                                    $subjectRecords = $records->whereIn('Student_ID', $subjectStudentIds)->values();
                                    $subjectMarks = $existingMarks[$subject->md_id] ?? [];
                                    $subjectStudentCount = count($subjectStudentIds);
                                    
                                    $savedCount = 0;
                                    foreach ($subjectStudentIds as $studentId) {
                                        if (isset($existingMarks[$subject->md_id][$studentId])) {
                                            $savedCount++;
                                        }
                                    }
                                    $isComplete = $savedCount == $subjectStudentCount && $subjectStudentCount > 0;
                                @endphp

                                <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="subject-form-{{ $subject->md_id }}"
                                    data-subject-id="{{ $subject->md_id }}">

                                    <form method="POST" action="{{ route('iteb.save.marks') }}" class="subject-form"
                                        data-subject-id="{{ $subject->md_id }}">
                                        @csrf
                                        <input type="hidden" name="subject_id" value="{{ $subject->md_id }}">

                                        <div class="card shadow-sm border-0 mb-3">
                                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fa fa-book me-2"></i> {{ $subject->md_name }}
                                                    <small class="text-muted ms-2">({{ $subjectStudentCount }}
                                                        students)</small>
                                                </h5>
                                                <div class="subject-status">
                                                    <span
                                                        class="save-indicator {{ $isComplete ? 'saved' : 'unsaved' }}"></span>
                                                    <span
                                                        class="saved-count">{{ $savedCount }}</span>/{{ $subjectStudentCount }}
                                                    saved
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="subject-search-box">
                                                        <i class="fa fa-search"></i>
                                                        <input type="text" class="form-control student-search-input"
                                                            placeholder="Search student by name or index number..."
                                                            aria-label="Search students">
                                                        <span class="search-result-count">
                                                            <span class="count-number">{{ $subjectStudentCount }}</span> students
                                                        </span>
                                                        <button type="button" class="subject-search-clear"
                                                            aria-label="Clear search">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="10%">#</th>
                                                                <th width="35%">Student Name</th>
                                                                <th width="35%">
                                                                    @if ($subject->total_papers > 1)
                                                                        Marks — {{ $subject->total_papers }} papers
                                                                        (each out of its own max, averaged on a 0-100
                                                                        scale)
                                                                    @else
                                                                        Marks
                                                                        (out of
                                                                        {{ rtrim(rtrim(number_format($subject->paper_max_scores[1] ?? 100, 2, '.', ''), '0'), '.') }})
                                                                    @endif
                                                                </th>
                                                                <th width="20%">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($subjectRecords as $key => $record)
                                                                @php
                                                                    $markValue = $subjectMarks[$record->Student_ID] ?? '';
                                                                    if ($markValue !== '' && is_numeric($markValue)) {
                                                                        $markValue = $markValue + 0;
                                                                    }
                                                                    $studentName = $studentNames[$record->Student_ID] ?? 'Unknown Student';
                                                                    $studentPapers = $existingPaperMarks[$subject->md_id][$record->Student_ID] ?? [];
                                                                @endphp
                                                                <tr
                                                                    data-search="{{ strtolower($studentName . ' ' . $record->Student_ID) }}">
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>
                                                                        <div class="fw-semibold">{{ $studentName }}</div>
                                                                        <small class="text-muted">{{ $record->Student_ID }}</small>
                                                                        <input type="hidden" name="students[]"
                                                                            value="{{ $record->Student_ID }}">
                                                                    </td>
                                                                    <td>
                                                                        @if ($subject->total_papers > 1)
                                                                            <div class="d-flex align-items-end paper-inputs-group"
                                                                                data-student="{{ $record->Student_ID }}">
                                                                                @for ($p = 1; $p <= $subject->total_papers; $p++)
                                                                                    @continue(!is_null($subject->allowed_papers) && !in_array($p, $subject->allowed_papers))
                                                                                    @php
                                                                                        $paperValue = $studentPapers[$p] ?? '';
                                                                                        if ($paperValue !== '' && is_numeric($paperValue)) {
                                                                                            $paperValue = $paperValue + 0;
                                                                                        }
                                                                                        $paperMax = (float) ($subject->paper_max_scores[$p] ?? 100);
                                                                                        $hasMark = $paperValue !== '';
                                                                                    @endphp
                                                                                    <div>
                                                                                        <input type="number"
                                                                                            name="marks[{{ $record->Student_ID }}][{{ $p }}]"
                                                                                            class="form-control mark-input paper-input {{ $hasMark ? 'saved' : '' }}"
                                                                                            placeholder="P{{ $p }}"
                                                                                            data-student="{{ $record->Student_ID }}"
                                                                                            data-paper="P{{ $p }}" data-max="{{ $paperMax }}"
                                                                                            data-original="{{ $paperValue }}"
                                                                                            value="{{ old('marks.' . $record->Student_ID . '.' . $p, $paperValue) }}"
                                                                                            min="0" max="{{ $paperMax }}" step="1">
                                                                                        <small class="text-muted d-block text-center"
                                                                                            style="font-weight:Bold;">P{{ $p }}
                                                                                            @if ($paperMax != 100)
                                                                                                /{{ rtrim(rtrim(number_format($paperMax, 2, '.', ''), '0'), '.') }}
                                                                                            @endif
                                                                                        </small>
                                                                                    </div>
                                                                                @endfor
                                                                                <div class="paper-avg-box">
                                                                                    <span class="badge text-white bg-secondary avg-badge">
                                                                                        Avg: {{ $markValue !== '' ? $markValue : '—' }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            @php $singleMax = (float) ($subject->paper_max_scores[1] ?? 100); @endphp
                                                                            <input type="number" name="marks[{{ $record->Student_ID }}]"
                                                                                class="form-control mark-input single-paper-input {{ $markValue !== '' ? 'saved' : '' }}"
                                                                                placeholder="Out of {{ rtrim(rtrim(number_format($singleMax, 2, '.', ''), '0'), '.') }}"
                                                                                data-student="{{ $record->Student_ID }}"
                                                                                data-max="{{ $singleMax }}"
                                                                                data-original="{{ $studentPapers[1] ?? $markValue }}"
                                                                                value="{{ old('marks.' . $record->Student_ID, $studentPapers[1] ?? $markValue) }}"
                                                                                min="0" max="{{ $singleMax }}" step="1">
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($markValue !== '')
                                                                            <span class="badge bg-success">Saved
                                                                                ({{ $markValue }})
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="card-footer bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm fill-all-btn">
                                                            <i class="fa fa-magic me-1"></i> Fill All (with 0)
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm clear-all-btn">
                                                            <i class="fa fa-eraser me-1"></i> Clear All
                                                        </button>
                                                    </div>
                                                    <button type="submit" class="btn text-white" style="background-color: #287C44;">
                                                        <i class="fa fa-save me-2"></i> Save {{ $subject->md_name }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- Global Action Buttons -->
                        <div class="action-buttons">
                            <button type="button" class="btn btn-outline-primary" id="saveAllVisibleBtn">
                                <i class="fa fa-eye me-2"></i> Save Current Subject
                            </button>
                            <button type="button" class="btn btn-success" id="saveAllSubjectsBtn">
                                <i class="fa fa-save me-2"></i> Save All Subjects
                            </button>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            <i class="fa fa-exclamation-triangle me-2"></i> No records found for selected filters.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(function($) {
            const studentIds = @json($records->pluck('Student_ID'));
            const subjects = @json($subjects->pluck('md_id'));
            const existingMarks = @json($existingMarks);
            const studentNamesMap = @json($studentNames);

            // ==================== TAB SWITCHING ====================
            $('.subject-tab').on('click', function() {
                const subjectId = $(this).data('subject-id');

                // Update tab active state
                $('.subject-tab').removeClass('active');
                $(this).addClass('active');

                // Update form visibility
                $('.tab-pane').removeClass('active');
                $(`#subject-form-${subjectId}`).addClass('active');

                // Reset that tab's search box and show all its rows
                const $pane = $(`#subject-form-${subjectId}`);
                $pane.find('.student-search-input').val('');
                $pane.find('tbody tr').show();
            });

            // ==================== STUDENT SEARCH ====================
            $(document).on('keyup', '.student-search-input', function() {
                const term = $(this).val().toLowerCase().trim();
                const $rows = $(this).closest('.tab-pane').find('tbody tr');

                $rows.each(function() {
                    const haystack = $(this).data('search') || '';
                    $(this).toggle(String(haystack).indexOf(term) !== -1);
                });
            });

            // ==================== AUTO-TAB FUNCTIONALITY ====================
            $(document).on('input', '.tab-pane.active .mark-input', function() {
                if ($(this).prop('disabled')) return;

                const $input = $(this);
                const max = parseFloat($input.data('max')) || 100;

                let currentValue = $input.val().replace(/[^0-9]/g, '');

                // Fix: Allow "100" as a valid value
                if (currentValue === '100') {
                    $input.val(currentValue).removeClass('is-invalid border-danger');
                    updateMarkStatus($input, currentValue);
                    moveToNextInput(this);
                    return;
                }

                // For values starting with 1, limit to 2 digits (allows 10-99)
                // But if it's exactly "100", we already handled it above
                if (currentValue.length > 2) {
                    // If it's 3 digits and starts with "10", it could be 100
                    if (currentValue.length === 3 && currentValue.substring(0, 2) === '10') {
                        // Allow 100 only
                        if (currentValue === '100') {
                            $input.val(currentValue).removeClass('is-invalid border-danger');
                            updateMarkStatus($input, currentValue);
                            moveToNextInput(this);
                            return;
                        }
                    }
                    // Otherwise limit to 2 digits for other cases (e.g., 1000 -> 10)
                    currentValue = currentValue.slice(0, 2);
                }

                $input.val(currentValue).removeClass('is-invalid border-danger');
                updateMarkStatus($input, currentValue);

                // Auto-advance when 2 digits are entered (or for custom max)
                const maxDigits = String(Math.floor(max)).length;
                if (currentValue.length === maxDigits && currentValue !== '') {
                    moveToNextInput(this);
                }
            });

            // Flag any pre-filled values that are over their paper's max
            $('.mark-input[data-max]').each(function() {
                const $input = $(this);
                const max = parseFloat($input.data('max')) || 100;
                const val = parseFloat($input.val());
                if ($input.val() !== '' && !isNaN(val) && val > max) {
                    $input.addClass('is-invalid border-danger');
                }
            });

            function moveToNextInput(currentInput) {
                const inputs = $('.tab-pane.active .mark-input:enabled');
                const currentIndex = inputs.index(currentInput);
                if (currentIndex < inputs.length - 1) {
                    $(inputs[currentIndex + 1]).focus();
                }
            }

            // Determines the true state of a single input
            function getMarkState($input) {
                const val = ($input.val() || '').toString().trim();
                const original = ($input.data('original') !== undefined && $input.data('original') !== null) ?
                    String($input.data('original')).trim() : '';

                if (val === '') return 'empty';
                if (val === original && original !== '') return 'saved';
                return 'pending';
            }

            function applyInputStateClasses($input, state) {
                $input.removeClass('saved unsaved pending-save');
                if (state === 'saved') {
                    $input.addClass('saved');
                } else if (state === 'pending') {
                    $input.addClass('pending-save');
                } else {
                    $input.addClass('unsaved');
                }
            }

            function updateMarkStatus(input, value) {
                const row = input.closest('tr');
                const statusBadge = row.find('td:last-child .badge');
                const paperGroup = input.closest('.paper-inputs-group');

                const state = getMarkState(input);
                applyInputStateClasses(input, state);

                if (paperGroup.length) {
                    const paperInputs = paperGroup.find('.paper-input');

                    const convertedVals = paperInputs.map(function() {
                        const raw = $(this).val();
                        if (raw === '') return null;
                        const max = parseFloat($(this).data('max')) || 100;
                        return (parseFloat(raw) / max) * 100;
                    }).get().filter(v => v !== null);

                    let anyPending = false;
                    let anyEmpty = false;
                    paperInputs.each(function() {
                        const s = getMarkState($(this));
                        if (s === 'pending') anyPending = true;
                        if (s === 'empty') anyEmpty = true;
                    });

                    if (convertedVals.length > 0) {
                        const avg = convertedVals.reduce((a, b) => a + b, 0) / convertedVals.length;
                        const avgRounded = Math.round(avg * 100) / 100;

                        if (!anyPending && !anyEmpty) {
                            paperGroup.find('.avg-badge')
                                .removeClass('bg-info')
                                .addClass('bg-secondary')
                                .text(`Avg: ${avgRounded}`);
                            statusBadge.removeClass('bg-warning bg-info').addClass('bg-success')
                                .text(`Saved (${avgRounded})`);
                        } else {
                            paperGroup.find('.avg-badge')
                                .removeClass('bg-secondary')
                                .addClass('bg-info')
                                .text(`Avg: ${avgRounded} (unsaved)`);
                            statusBadge.removeClass('bg-warning bg-success').addClass('bg-info text-white')
                                .text('Unsaved changes');
                        }
                    } else {
                        paperGroup.find('.avg-badge').removeClass('bg-info').addClass('bg-secondary').text('Avg: —');
                        statusBadge.removeClass('bg-success bg-info').addClass('bg-warning').text('Pending');
                    }
                } else if (state === 'saved') {
                    const max = parseFloat(input.data('max')) || 100;
                    const converted = Math.round((parseFloat(value) / max) * 100 * 100) / 100;
                    statusBadge.removeClass('bg-warning bg-info').addClass('bg-success').text(`Saved (${converted})`);
                } else if (state === 'pending') {
                    statusBadge.removeClass('bg-warning bg-success').addClass('bg-info').text('Unsaved changes');
                } else {
                    statusBadge.removeClass('bg-success bg-info').addClass('bg-warning').text('Pending');
                }

                // Update tab progress
                updateTabProgress(input.closest('.tab-pane').data('subject-id'));
            }

            // ==================== KEYBOARD NAVIGATION ====================
            $(document).on('keydown', '.tab-pane.active .mark-input', function(e) {
                const inputs = $('.tab-pane.active .mark-input:enabled');
                const currentIndex = inputs.index(this);

                if (e.key === 'Backspace' && $(this).val().length === 0 && currentIndex > 0) {
                    $(inputs[currentIndex - 1]).focus();
                } else if (e.key === 'ArrowLeft' && currentIndex > 0) {
                    e.preventDefault();
                    $(inputs[currentIndex - 1]).focus();
                } else if (e.key === 'ArrowRight' && currentIndex < inputs.length - 1) {
                    e.preventDefault();
                    $(inputs[currentIndex + 1]).focus();
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (currentIndex < inputs.length - 1) {
                        $(inputs[currentIndex + 1]).focus();
                    }
                }
            });

            // ==================== FILL ALL FUNCTIONALITY ====================
            $('.fill-all-btn').on('click', function() {
                const form = $(this).closest('form');
                const subjectId = form.data('subject-id');

                Swal.fire({
                    title: 'Fill all marks?',
                    text: 'This will set all empty marks to 0. Continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, fill all',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.find('.mark-input').each(function() {
                            if ($(this).val() === '') {
                                $(this).val('0');
                                updateMarkStatus($(this), '0');
                            }
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Filled!',
                            text: 'All empty marks set to 0',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // ==================== CLEAR ALL FUNCTIONALITY ====================
            $('.clear-all-btn').on('click', function() {
                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Clear all marks?',
                    text: 'This will remove all marks for this subject. Continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear all',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.find('.mark-input').val('');
                        form.find('.mark-input').each(function() {
                            updateMarkStatus($(this), '');
                        });
                    }
                });
            });

            // ==================== UPDATE TAB PROGRESS ====================
            function updateTabProgress(subjectId) {
                const tab = $(`.subject-tab[data-subject-id="${subjectId}"]`);
                const form = $(`#subject-form-${subjectId}`);
                const inputs = form.find('.mark-input');
                const totalInputs = inputs.length;
                const filledInputs = inputs.filter(function() {
                    return $(this).val() !== '';
                }).length;
                const pending = totalInputs - filledInputs;
                const progressPercent = (filledInputs / totalInputs) * 100;

                // Update progress bar
                tab.find('.progress-fill').css('width', progressPercent + '%');

                // Update stats row
                const statsRow = tab.find('.stats-row');
                statsRow.find('span:first-child').html(
                    `<i class="fa fa-save"></i> ${filledInputs}/${totalInputs} saved`);
                statsRow.find('span:last-child').html(
                    `<i class="fa fa-percent"></i> ${Math.round(progressPercent)}%`);

                // Update pending badge - remove existing and add new one
                const tabHeader = tab.find('.tab-header');
                const statusBadgeContainer = tabHeader.find('.tab-status-badge');
                
                // Clear the container and add fresh badge
                statusBadgeContainer.empty();
                
                if (pending > 0) {
                    statusBadgeContainer.append(`
                        <span class="pending-badge">
                            <i class="fa fa-clock"></i> ${pending}
                        </span>
                    `);
                } else if (totalInputs > 0) {
                    statusBadgeContainer.append(`
                        <span class="saved-badge">
                            <i class="fa fa-check-circle"></i> Complete
                        </span>
                    `);
                }

                // Update status in form header
                form.find('.subject-status .save-indicator')
                    .removeClass('saved unsaved')
                    .addClass(filledInputs === totalInputs ? 'saved' : 'unsaved');
                form.find('.saved-count').text(filledInputs);
            }

            // ==================== FORM SUBMISSION ====================
            $('.subject-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const subjectName = form.closest('.tab-pane').find('.card-header h5').text().trim();
                const subjectId = form.data('subject-id');

                // Validate all marks are filled
                const emptyInputs = form.find('.mark-input').filter(function() {
                    return $(this).val() === '';
                });

                if (emptyInputs.length > 0) {
                    // Group missing inputs by student
                    const missingByStudent = {};

                    emptyInputs.each(function() {
                        const $input = $(this);
                        const studentId = $input.data('student');
                        const paperLabel = $input.data('paper');

                        if (!missingByStudent[studentId]) {
                            missingByStudent[studentId] = [];
                        }
                        if (paperLabel) {
                            missingByStudent[studentId].push(paperLabel);
                        }
                    });

                    const studentList = Object.keys(missingByStudent).map(function(id) {
                        const name = studentNamesMap[id] || id;
                        const papers = missingByStudent[id];
                        const paperNote = papers.length > 0 ?
                            ` <span class="text-danger">(missing ${papers.join(', ')})</span>` :
                            '';
                        return `${name}${paperNote}`;
                    }).join('<br>');

                    const missingCount = Object.keys(missingByStudent).length;

                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Submission',
                        html: `
                            <p>All students must have marks for <strong>${subjectName}</strong>.</p>
                            <p><strong>Missing students (${missingCount}):</strong></p>
                            <div style="max-height:250px; overflow-y:auto; text-align:left;">
                                ${studentList}
                            </div>
                        `,
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validate mark ranges
                const invalidInputs = form.find('.mark-input').filter(function() {
                    const val = parseFloat($(this).val());
                    const max = parseFloat($(this).data('max')) || 100;
                    return isNaN(val) || val < 0 || val > max;
                });

                invalidInputs.addClass('is-invalid border-danger');

                if (invalidInputs.length > 0) {
                    invalidInputs.first().trigger('focus');
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Marks',
                        text: 'Each mark must be between 0 and that paper\'s maximum score.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirm submission
                Swal.fire({
                    title: 'Submit Marks?',
                    html: `Save marks for <strong>${subjectName}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, save',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Saving...',
                            html: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: 'Marks saved successfully',
                                    confirmButtonText: 'OK',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON && xhr.responseJSON.message ?
                                        xhr.responseJSON.message :
                                        'Failed to save marks',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            // ==================== SAVE ALL SUBJECTS ====================
            $('#saveAllSubjectsBtn').on('click', function() {
                const forms = $('.subject-form');
                let hasEmptyMarks = false;
                let hasInvalidMarks = false;
                let emptySubjects = [];

                // Validate all forms first
                forms.each(function() {
                    const form = $(this);
                    const subjectName = form.closest('.tab-pane').find('.card-header h5').text()
                        .trim();
                    const emptyInputs = form.find('.mark-input').filter(function() {
                        return $(this).val() === '';
                    });

                    if (emptyInputs.length > 0) {
                        hasEmptyMarks = true;
                        emptySubjects.push(subjectName);
                    }

                    const invalidInputs = form.find('.mark-input').filter(function() {
                        const val = parseFloat($(this).val());
                        const max = parseFloat($(this).data('max')) || 100;
                        return $(this).val() !== '' && (isNaN(val) || val < 0 || val > max);
                    });

                    if (invalidInputs.length > 0) {
                        invalidInputs.addClass('is-invalid border-danger');
                        hasInvalidMarks = true;
                    }
                });

                if (hasEmptyMarks) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Marks',
                        html: `
                            <p>The following subjects have empty marks:</p>
                            <ul style="text-align:left;">
                                ${emptySubjects.map(s => `<li>${s}</li>`).join('')}
                            </ul>
                        `,
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                if (hasInvalidMarks) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Marks',
                        text: 'Some marks are invalid. All marks must be between 0 and their maximum.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Confirm saving all
                Swal.fire({
                    title: 'Save All Subjects?',
                    html: `This will save marks for <strong>${forms.length} subjects</strong>.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, save all',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show overall progress
                        Swal.fire({
                            title: 'Saving all subjects...',
                            html: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit forms sequentially
                        let completed = 0;
                        let errors = [];

                        function submitForm(index) {
                            if (index >= forms.length) {
                                // All done
                                Swal.fire({
                                    icon: errors.length > 0 ? 'warning' : 'success',
                                    title: errors.length > 0 ? 'Completed with errors' :
                                        'All Saved!',
                                    html: `
                                        Saved ${completed - errors.length}/${forms.length} subjects.<br>
                                        ${errors.length > 0 ? 'Errors: ' + errors.join(', ') : ''}
                                    `,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                                return;
                            }

                            const form = $(forms[index]);
                            const subjectName = form.closest('.tab-pane').find('.card-header h5')
                                .text().trim();

                            $.ajax({
                                url: form.attr('action'),
                                method: 'POST',
                                data: form.serialize(),
                                success: function() {
                                    completed++;
                                    submitForm(index + 1);
                                },
                                error: function(xhr) {
                                    completed++;
                                    errors.push(subjectName);
                                    submitForm(index + 1);
                                }
                            });
                        }

                        submitForm(0);
                    }
                });
            });

            // ==================== SAVE CURRENT SUBJECT ====================
            $('#saveAllVisibleBtn').on('click', function() {
                const activeForm = $('.tab-pane.active .subject-form');
                activeForm.submit();
            });

            // Initialize all tabs progress on load
            subjects.forEach(function(subjectId) {
                updateTabProgress(subjectId);
            });
        });

        // ==================== SEARCH CLEAR BUTTON ====================
        $(document).on('input', '.student-search-input', function() {
            $(this).siblings('.subject-search-clear').css('display', this.value ? 'flex' : 'none');
        });

        $(document).on('click', '.subject-search-clear', function() {
            const $input = $(this).siblings('.student-search-input');
            $input.val('').trigger('keyup');
            $(this).css('display', 'none');
        });
    </script>
@endsection