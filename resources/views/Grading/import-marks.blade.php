<?php
use App\Http\Controllers\Helper;
?>
@extends('layouts-side-bar.master')
@section('content')
    <div class="side-app">

        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card bg-primary">
                    <div class="card-header">
                        @include('layouts.grading-buttons')
                    </div>
                </div>
            </div>
        </div>

        <style>
            .school-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
                border: 1px solid #eef2f7;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .school-card:hover {
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
                transform: translateY(-2px);
            }

            .school-header {
                background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
                border-bottom: 1px solid #e2e8f0;
            }

            .school-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background: linear-gradient(135deg, #287C44 0%, #34A853 100%);
                border-radius: 10px;
                color: white;
                font-size: 1.25rem;
            }

            .school-name {
                color: #1e293b;
                font-weight: 700;
                font-size: 1.5rem;
            }

            .exam-card {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 1.5rem;
                height: 100%;
                transition: all 0.3s ease;
            }

            .exam-card:hover {
                border-color: #287C44;
                box-shadow: 0 4px 12px rgba(40, 124, 68, 0.1);
            }

            .exam-card-header {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .exam-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 56px;
                height: 56px;
                border-radius: 12px;
                margin-right: 1rem;
            }

            .exam-card--uace .exam-icon {
                background: linear-gradient(135deg, #0F4C22 0%, #0F4C22 100%);
                color: white;
            }

            .exam-card--uce .exam-icon {
                background: linear-gradient(135deg, #0F4C22 0%, #0F4C22 100%);
                color: white;
            }

            .exam-card--ple .exam-icon {
                background: linear-gradient(135deg, #E65100, #FF6D00);
            }

            .exam-title {
                color: #1e293b;
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .exam-description {
                color: #64748b;
                font-size: 0.875rem;
                margin-bottom: 0;
            }

            .exam-stats {
                display: flex;
                gap: 2rem;
            }

            .stat-item {
                display: flex;
                flex-direction: column;
            }

            .stat-label {
                color: #64748b;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }

            .stat-value {
                font-weight: 600;
                color: #1e293b;
            }

            .btn-icon {
                width: 40px;
                height: 40px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
            }

            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
            }

            .empty-state-icon {
                font-size: 4rem;
                color: #cbd5e1;
                margin-bottom: 1.5rem;
            }

            .empty-state h3 {
                color: #475569;
                margin-bottom: 0.5rem;
            }

            .empty-state p {
                color: #94a3b8;
            }

            .modal-header {
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .modal-footer {
                border-top: 1px solid #dee2e6;
            }

            .border-dashed {
                border-style: dashed !important;
            }

            .bg-light-info {
                background-color: rgba(13, 202, 240, 0.1) !important;
            }

            .bg-light-warning {
                background-color: rgba(255, 193, 7, 0.1) !important;
            }

            .btn-close-white {
                filter: invert(1) grayscale(100%) brightness(200%);
            }

            .modal-content {
                border-radius: 12px;
                overflow: hidden;
            }

            .swal2-container {
                z-index: 99999 !important;
            }
        </style>

        <div class="row">
            <div class="col-lg-12">
                <!-- Results -->
                <div class="card mt-4" id="resultsCard">
                    <div
                        class="card-header bg-primary-gradient text-white d-flex justify-content-between align-items-center p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-white-20 rounded-circle p-3 me-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-1 ml-1">Year Summary</h3>
                            </div>
                        </div>

                        @php
                            $activeYear = Helper::active_year();
                            $uceYear = Helper::activeUploadingUCEYear();
                            $uaceYear = Helper::activeUploadingUACEYear();
                        @endphp

                        <div class="d-flex gap-4 align-items-stretch">
                            <div
                                class="year-status-card bg-white-10 p-3 rounded-3 d-flex flex-column justify-content-center text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <span class="status-indicator bg-success" style="margin-right: 5px;"></span>
                                    <h6 class="mb-0 text-white-90">Active Year</h6>
                                </div>
                                <h4 class="fw-bold mb-0 @if($activeYear == 'No Active year Set') text-danger @endif">
                                    {{ $activeYear }}
                                </h4>
                            </div>

                            <div
                                class="year-status-card bg-white-10 p-3 rounded-3 d-flex flex-column justify-content-center text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <span class="status-indicator bg-success me-2" style="margin-right: 5px;"></span>
                                    <h6 class="mb-0 text-white-90">A-LEVEL (UACE) Uploading</h6>
                                </div>
                                <h4
                                    class="fw-bold mb-0 @if($uaceYear == 'Upload Year Not Set') text-danger @endif">
                                    {{ $uaceYear }}
                                </h4>
                            </div>

                            <div
                                class="year-status-card bg-white-10 p-3 rounded-3 d-flex flex-column justify-content-center text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <span class="status-indicator bg-success me-2" style="margin-right: 5px;"></span>
                                    <h6 class="mb-0 text-white-90">O-LEVEL (UCE) Uploading</h6>
                                </div>
                                <h4
                                    class="fw-bold mb-0 @if($uceYear == 'Upload Year Not Set') text-danger @endif">
                                    {{ $uceYear }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <style>
                        .bg-primary-gradient {
                            background: linear-gradient(135deg, #026837 0%, #026837 100%);
                        }

                        .bg-white-10 {
                            background: rgba(255, 255, 255, 0.1);
                        }

                        .bg-white-20 {
                            background: rgba(255, 255, 255, 0.2);
                        }

                        .text-white-70 {
                            color: rgba(255, 255, 255, 0.7);
                        }

                        .text-white-90 {
                            color: rgba(255, 255, 255, 0.9);
                        }

                        .status-indicator {
                            width: 8px;
                            height: 8px;
                            border-radius: 50%;
                            display: inline-block;
                        }

                        .year-status-card {
                            min-width: 160px;
                        }
                    </style>

                    <div class="card-body bg-white" id="searchResults">
                        @if ($groupedStudents->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h3>No Students Found</h3>
                                <p>No students match your current search criteria</p>
                            </div>
                        @else
                            @foreach ($groupedStudents as $schoolName => $students)
                                <div class="school-card mb-5">
                                    <!-- Header Section -->
                                    <div class="school-header d-flex justify-content-between align-items-center p-4">
                                        <div class="school-info">
                                            <div class="d-flex align-items-center">
                                                <span class="school-icon">
                                                    <i class="fas fa-school"></i>
                                                </span>
                                                <div class="ms-3">
                                                    <h2 class="school-name mb-1"><span
                                                            style="padding-left: 10px;">{{ $schoolName }}</span></h2>
                                                    <div class="school-meta">
                                                        <span class="badge bg-primary-soft text-primary me-2">
                                                            <i class="fas fa-users me-1"></i>
                                                            {{ Helper::schoolStudentsCount($students->first()->school_id) }}
                                                            Students
                                                        </span>
                                                        <span class="text-muted">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ Helper::active_year() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="school-actions">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-icon" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <h6 class="dropdown-header">Export Actions</h6>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item export-btn"
                                                        href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'uace']) }}">
                                                        <i class="fas fa-file-export text-success me-2"></i>
                                                        Export A-LEVEL
                                                    </a>
                                                    <a class="dropdown-item export-btn"
                                                        href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'uce']) }}">
                                                        <i class="fas fa-file-export text-success me-2"></i>
                                                        Export O-LEVEL
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Exam Management Section -->
                                    <div class="school-content p-4">
                                        <div class="row g-4">
                                            <!-- UACE Section -->
                                            <div class="col-lg-6">
                                                <div class="exam-card exam-card--uace">
                                                    <div class="exam-card-header">
                                                        <div class="exam-icon">
                                                            <i class="fas fa-graduation-cap"></i>
                                                        </div>
                                                        <div class="exam-info">
                                                            <h4 class="exam-title">A-LEVEL (UACE) Exams</h4>
                                                            <p class="exam-description">Secondary level examination data
                                                                management</p>
                                                        </div>
                                                    </div>
                                                    <div class="exam-card-body">
                                                        <div class="exam-stats">
                                                            <div class="stat-item">
                                                                <span class="stat-label">Status</span>
                                                                <span class="stat-value text-success">Active</span>
                                                            </div>
                                                        </div>
                                                        <div class="exam-actions mt-4">
                                                            <div class="row g-2">

                                                                @php
                                                                    $uaceUploadYear = Helper::activeUploadingUACEYear();
                                                                    $uceUploadYear = Helper::activeUploadingUCEYear();
                                                                @endphp

                                                                <div class="col-6">
                                                                    @if ($uaceUploadYear === 'Upload Year Not Set')
                                                                        <button class="btn btn-secondary w-100 upload-blocked-btn"
                                                                            data-type="uace">
                                                                            <i class="fas fa-lock me-2"></i>
                                                                            Upload Closed
                                                                        </button>

                                                                    @elseif (Helper::uploadedSchoolExam($students->first()->school_id, 'uace'))
                                                                        <button class="btn btn-warning w-100 upload-confirm-btn-uace"
                                                                            data-school-id="{{ $students->first()->school_id }}"
                                                                            data-school-name="{{ $schoolName }}"
                                                                            data-file-category="uace">
                                                                            <i class="fas fa-check-circle me-2"></i>
                                                                            Uploaded
                                                                        </button>

                                                                    @else
                                                                        <button class="btn btn-primary w-100 open-upload-modal"
                                                                            data-bs-toggle="modal" data-bs-target="#importUACEModal"
                                                                            data-school-id="{{ $students->first()->school_id }}"
                                                                            data-school-name="{{ $schoolName }}"
                                                                            data-file-category="uace">
                                                                            <i class="fas fa-upload me-2"></i> Import
                                                                        </button>
                                                                    @endif
                                                                </div>

                                                                <script>
                                                                    document.addEventListener('DOMContentLoaded', function () {
                                                                        document.addEventListener('click', function (e) {
                                                                            if (e.target.closest('.upload-confirm-btn-uace')) {
                                                                                const button = e.target.closest('.upload-confirm-btn-uace');
                                                                                const schoolId = button.getAttribute('data-school-id');
                                                                                const schoolName = button.getAttribute('data-school-name');
                                                                                const fileCategory = button.getAttribute('data-file-category');

                                                                                Swal.fire({
                                                                                    title: 'Marks Already Uploaded',
                                                                                    html: `Marks for <strong>${schoolName}</strong> have already been uploaded.<br>Do you want to upload new marks and replace the existing ones?`,
                                                                                    icon: 'warning',
                                                                                    showCancelButton: true,
                                                                                    confirmButtonColor: '#3085d6',
                                                                                    cancelButtonColor: '#d33',
                                                                                    confirmButtonText: 'Yes, Replace',
                                                                                    cancelButtonText: 'Cancel'
                                                                                }).then((result) => {
                                                                                    if (result.isConfirmed) {
                                                                                        const modalElement = document.getElementById('importUACEModal');

                                                                                        if (modalElement) {
                                                                                            // Set the values in the modal inputs
                                                                                            document.getElementById('uace_school_id').value = schoolId;
                                                                                            document.getElementById('uace_file_category').value = fileCategory;
                                                                                            document.getElementById('uace_school_name_display').value = schoolName;

                                                                                            // Automatically check the overwrite checkbox since this is an overwrite action
                                                                                            document.getElementById('uace-overwrite').checked = true;

                                                                                            const importModal = new bootstrap.Modal(modalElement);
                                                                                            importModal.show();

                                                                                            const event = new CustomEvent('overwrite-confirmed-uace', {
                                                                                                detail: {
                                                                                                    schoolId: schoolId,
                                                                                                    schoolName: schoolName,
                                                                                                    fileCategory: fileCategory
                                                                                                }
                                                                                            });
                                                                                            modalElement.dispatchEvent(event);
                                                                                        }
                                                                                    }
                                                                                });
                                                                            }
                                                                        });
                                                                    });
                                                                </script>
                                                                <div class="col-6">
                                                                    <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'uace']) }}"
                                                                        class="btn btn-success w-100 export-btn">
                                                                        <i class="fas fa-download me-2"></i>
                                                                        Export
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- UCE Section -->
                                            <div class="col-lg-6">
                                                <div class="exam-card exam-card--uce">
                                                    <div class="exam-card-header">
                                                        <div class="exam-icon">
                                                            <i class="fas fa-book-open"></i>
                                                        </div>
                                                        <div class="exam-info">
                                                            <h4 class="exam-title">O-LEVEL (UCE) Exams</h4>
                                                            <p class="exam-description">Preparatory level examination data
                                                                management</p>
                                                        </div>
                                                    </div>
                                                    <div class="exam-card-body">
                                                        <div class="exam-stats">
                                                            <div class="stat-item">
                                                                <span class="stat-label">Status</span>
                                                                <span class="stat-value text-success">Active</span>
                                                            </div>
                                                        </div>
                                                        <div class="exam-actions mt-4">
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                      @if ($uceUploadYear === 'Upload Year Not Set')
                                                                        <button class="btn btn-secondary w-100 upload-blocked-btn"
                                                                            data-type="uce">
                                                                            <i class="fas fa-lock me-2"></i>
                                                                            Upload Closed
                                                                        </button>
                                                                    @elseif (Helper::uploadedSchoolExam($students->first()->school_id, 'uce'))
                                                                        <button class="btn btn-warning w-100 upload-confirm-btn"
                                                                            data-school-id="{{ $students->first()->school_id }}"
                                                                            data-school-name="{{ $schoolName }}"
                                                                            data-file-category="uce">
                                                                            <i class="fas fa-check-circle me-2"></i>
                                                                            Uploaded
                                                                        </button>
                                                                    @else
                                                                        <button class="btn btn-primary w-100 import-trigger-btn"
                                                                            data-bs-toggle="modal" data-bs-target="#importUCEModal"
                                                                            data-school-id="{{ $students->first()->school_id }}"
                                                                            data-school-name="{{ $schoolName }}"
                                                                            data-file-category="uce">
                                                                            <i class="fas fa-upload me-2"></i> Import
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                <script>
                                                                    document.addEventListener('DOMContentLoaded', function () {
                                                                        document.addEventListener('click', function (e) {
                                                                            if (e.target.closest('.upload-confirm-btn')) {
                                                                                const button = e.target.closest('.upload-confirm-btn');
                                                                                const schoolId = button.getAttribute('data-school-id');
                                                                                const schoolName = button.getAttribute('data-school-name');
                                                                                const fileCategory = button.getAttribute('data-file-category');

                                                                                Swal.fire({
                                                                                    title: 'Marks Already Uploaded',
                                                                                    html: `Marks for <strong>${schoolName}</strong> have already been uploaded.<br>Do you want to upload new marks and replace the existing ones?`,
                                                                                    icon: 'warning',
                                                                                    showCancelButton: true,
                                                                                    confirmButtonColor: '#3085d6',
                                                                                    cancelButtonColor: '#d33',
                                                                                    confirmButtonText: 'Yes, Replace',
                                                                                    cancelButtonText: 'Cancel'
                                                                                }).then((result) => {
                                                                                    if (result.isConfirmed) {
                                                                                        const modalElement = document.getElementById('importUCEModal');

                                                                                        if (modalElement) {
                                                                                            // Set the values in the modal inputs
                                                                                            document.getElementById('uce_school_id').value = schoolId;
                                                                                            document.getElementById('uce_file_category').value = fileCategory;
                                                                                            document.getElementById('uce_school_name_display').value = schoolName;

                                                                                            // Automatically check the overwrite checkbox since this is an overwrite action
                                                                                            document.getElementById('uce-overwrite').checked = true;

                                                                                            const importModal = new bootstrap.Modal(modalElement);
                                                                                            importModal.show();

                                                                                            const event = new CustomEvent('overwrite-confirmed', {
                                                                                                detail: {
                                                                                                    schoolId: schoolId,
                                                                                                    schoolName: schoolName,
                                                                                                    fileCategory: fileCategory
                                                                                                }
                                                                                            });
                                                                                            modalElement.dispatchEvent(event);
                                                                                        }
                                                                                    }
                                                                                });
                                                                            }
                                                                        });
                                                                    });
                                                                </script>
                                                                <div class="col-6">
                                                                    <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'uce']) }}"
                                                                        class="btn btn-success w-100 export-btn">
                                                                        <i class="fas fa-download me-2"></i>
                                                                        Export
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PLE Section -->
                                            <div class="col-lg-6">
                                                <div class="exam-card exam-card--ple">
                                                    <div class="exam-card-header">
                                                        <div class="exam-icon">
                                                            <i class="fas fa-child"></i>
                                                        </div>
                                                        <div class="exam-info">
                                                            <h4 class="exam-title">PLE Exams</h4>
                                                            <p class="exam-description">Primary level examination data management</p>
                                                        </div>
                                                    </div>
                                                    <div class="exam-card-body">
                                                        <div class="exam-stats">
                                                            @php
                                                                $pleUploadYear = Helper::activeUploadingPleYear();
                                                            @endphp
                                                            <div class="stat-item">
                                                                <span class="stat-label">Upload Year</span>
                                                                <span class="stat-value @if($pleUploadYear == 'Upload Year Not Set') text-danger @endif">
                                                                    {{ $pleUploadYear }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @if ($pleUploadYear === 'Upload Year Not Set')
                                                            <button class="btn btn-secondary w-100" disabled
                                                                title="PLE upload is not active">
                                                                <i class="fas fa-lock me-2"></i> PLE Upload Inactive
                                                            </button>
                                                        @elseif (Helper::uploadedSchoolExam($students->first()->school_id, 'ple'))
                                                            <button class="btn btn-warning w-100 upload-confirm-btn-ple"
                                                                data-school-id="{{ $students->first()->school_id }}"
                                                                data-school-name="{{ $schoolName }}"
                                                                data-file-category="ple">
                                                                <i class="fas fa-sync-alt me-2"></i> Re-upload PLE
                                                            </button>
                                                        @else
                                                            <button class="btn btn-primary w-100 upload-btn-ple"
                                                                data-school-id="{{ $students->first()->school_id }}"
                                                                data-school-name="{{ $schoolName }}"
                                                                data-file-category="ple">
                                                                <i class="fas fa-upload me-2"></i> Upload PLE Results
                                                            </button>
                                                        @endif
                                                        <div class="mt-2">
                                                            <a href="{{ route('students.export', ['schoolId' => $students->first()->school_id, 'type' => 'ple']) }}"
                                                                class="btn btn-success w-100 export-btn">
                                                                <i class="fas fa-download me-2"></i> Export
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Import UACE Modal -->
                <div class="modal fade" id="importUACEModal" tabindex="-1" aria-labelledby="importUACEModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <form method="POST" action="{{ route('import.uace') }}" enctype="multipart/form-data"
                            class="modal-content border-0 shadow-lg" id="importUACEForm">
                            @csrf
                            <input type="hidden" name="school_id" id="uace_school_id">
                            <input type="hidden" name="file_category" id="uace_file_category">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title d-flex align-items-center" id="importUACEModalLabel">
                                    <i class="fas fa-file-import" style="margin-right: 5px;"></i>
                                    <span>Import A-LEVEL (UACE) Exam Results</span>
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="alert alert-info border-0 bg-light-info d-flex align-items-center mb-4"
                                    role="alert">
                                    <i class="fas fa-info-circle mr-2 text-info" style="font-size: 1.25rem;"></i>
                                    <div>
                                        <small class="text-uppercase font-weight-bold d-block">Instructions</small>
                                        Upload Excel file containing UACE exam results. Ensure the file follows the
                                        required format.
                                    </div>
                                </div>


                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold m-0 text-dark">Select Excel File</label>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                            Required
                                        </span>
                                    </div>

                                    <div class="position-relative rounded-4 bg-light border border-2 border-dashed border-primary 
                                                                                            d-flex align-items-center justify-content-center"
                                        style="height: 180px; transition: all 0.3s ease;">
                                        <input type="file" name="file" id="uace-file-input"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                            style="cursor: pointer; z-index: 5;" accept=".xlsx,.xls,.csv" required>

                                        <div class="text-center p-3">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center 
                                                                                                    justify-content-center mb-3 shadow-sm"
                                                style="width: 54px; height: 54px;">
                                                <i class="fas fa-file-excel fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1" id="uace-label">Drop your Excel file here</h6>
                                            <p class="text-muted small mb-0" id="uace-sub-label">or click to browse
                                                computer</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 px-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Supports: .xlsx, .xls, .csv
                                        </small>
                                        <small class="text-muted">Max: 10MB</small>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Academic Year</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}" readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" id="uace_school_name_display" readonly>
                                    <small class="text-muted">Results will be imported for this school</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="uace-overwrite" name="overwrite"
                                        disabled checked>
                                    <label class="form-check-label" for="uace-overwrite">
                                        Overwrite existing results for this exam
                                    </label>
                                    <small class="text-muted d-block mt-1">If checked, existing results will be
                                        replaced for this year</small>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm" id="confirmUACEUploadBtn">
                                    <i class="fas fa-upload me-1"></i> Upload & Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Import UCE Modal -->
                <div class="modal fade" id="importUCEModal" tabindex="-1" aria-labelledby="importUCEModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <form method="POST" action="{{ route('import.uce') }}" enctype="multipart/form-data"
                            class="modal-content border-0 shadow-lg" id="importUCEForm">
                            @csrf
                            <input type="hidden" name="school_id" id="uce_school_id">
                            <input type="hidden" name="file_category" id="uce_file_category">

                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title d-flex align-items-center" id="importUCEModalLabel">
                                    <i class="fas fa-file-import me-2" style="margin-right:5px;"></i>
                                    <span>Import O-LEVEL (UCE) Exam Results</span>
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="alert alert-info border-0 bg-light-info d-flex align-items-center mb-4"
                                    role="alert">
                                    <i class="fas fa-info-circle mr-2 text-info" style="font-size: 1.25rem;"></i>
                                    <div>
                                        <small class="text-uppercase font-weight-bold d-block">Instructions</small>
                                        Upload Excel file containing UCE exam results. Ensure the file follows the
                                        required format.
                                    </div>
                                </div>


                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold m-0 text-dark">Select Excel File</label>
                                        <span
                                            class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">
                                            Required
                                        </span>
                                    </div>

                                    <div class="position-relative rounded-4 bg-light border border-2 border-dashed border-info 
                                                                                            d-flex align-items-center justify-content-center"
                                        style="height: 180px; transition: all 0.3s ease;">
                                        <input type="file" name="file" id="uce-file-input"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                            style="cursor: pointer; z-index: 5;" accept=".xlsx,.xls,.csv" required>

                                        <div class="text-center p-3">
                                            <div class="bg-info text-white rounded-circle d-inline-flex align-items-center 
                                                                                                    justify-content-center mb-3 shadow-sm"
                                                style="width: 54px; height: 54px;">
                                                <i class="fas fa-file-excel fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1" id="uce-label">Drop your Excel file here</h6>
                                            <p class="text-muted small mb-0" id="uce-sub-label">or click to browse
                                                computer</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 px-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Supports: .xlsx, .xls, .csv
                                        </small>
                                        <small class="text-muted">Max: 10MB</small>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Academic Year</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}" readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" id="uce_school_name_display" readonly>
                                    <small class="text-muted">Results will be imported for this school</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}" readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="uce-overwrite" name="overwrite"
                                        disabled checked>

                                    <label class="form-check-label" for="uce-overwrite">
                                        Overwrite existing results for this exam
                                    </label>
                                    <small class="text-muted d-block mt-1">If checked, existing results will be
                                        replaced for this year</small>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-info px-4 shadow-sm text-white"
                                    id="confirmUCEUploadBtn">
                                    <i class="fas fa-upload me-1"></i> Upload & Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Import PLE Modal -->
                <div class="modal fade" id="importPleModal" tabindex="-1" aria-labelledby="importPleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <form method="POST" action="{{ route('import.ple') }}" enctype="multipart/form-data"
                            class="modal-content border-0 shadow-lg" id="importPleForm">
                            @csrf
                            <input type="hidden" name="school_id" id="ple_school_id">
                            <input type="hidden" name="file_category" id="ple_file_category">

                            <div class="modal-header text-white" style="background: #E65100;">
                                <h5 class="modal-title d-flex align-items-center" id="importPleModalLabel">
                                    <i class="fas fa-file-import me-2" style="margin-right:5px;"></i>
                                    <span>Import PLE Exam Results</span>
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="alert alert-warning border-0 bg-light d-flex align-items-center mb-4" role="alert">
                                    <i class="fas fa-info-circle mr-2" style="font-size: 1.25rem; color:#E65100;"></i>
                                    <div>
                                        <small class="text-uppercase font-weight-bold d-block">Instructions</small>
                                        Upload Excel file containing PLE (Primary Level Examination) results. Ensure the file follows the required format.
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold m-0 text-dark">Select Excel File</label>
                                        <span class="badge rounded-pill px-3" style="background:#FFF3E0; color:#E65100; border:1px solid #E65100;">Required</span>
                                    </div>

                                    <div class="position-relative rounded-4 bg-light border border-2 border-dashed
                                                d-flex align-items-center justify-content-center"
                                        style="height: 180px; border-color: #E65100 !important; transition: all 0.3s ease;">
                                        <input type="file" name="file" id="ple-file-input"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                            style="cursor: pointer; z-index: 5;" accept=".xlsx,.xls,.csv" required>

                                        <div class="text-center p-3">
                                            <div class="text-white rounded-circle d-inline-flex align-items-center
                                                        justify-content-center mb-3 shadow-sm"
                                                style="width: 54px; height: 54px; background:#E65100;">
                                                <i class="fas fa-file-excel fs-3"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1" id="ple-label">Drop your Excel file here</h6>
                                            <p class="text-muted small mb-0" id="ple-sub-label">or click to browse computer</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2 px-1">
                                        <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Supports: .xlsx, .xls, .csv</small>
                                        <small class="text-muted">Max: 10MB</small>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Academic Year</label>
                                    <input type="text" class="form-control" value="{{ Helper::active_year() }}" readonly>
                                    <small class="text-muted">Results will be imported for the active academic year</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">School Name</label>
                                    <input type="text" class="form-control" id="ple_school_name_display" readonly>
                                    <small class="text-muted">Results will be imported for this school</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="ple-overwrite" name="overwrite" disabled checked>
                                    <label class="form-check-label" for="ple-overwrite">
                                        Overwrite existing results for this exam
                                    </label>
                                    <small class="text-muted d-block mt-1">If checked, existing results will be replaced for this year</small>
                                </div>
                            </div>

                            <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn px-4 shadow-sm text-white" style="background:#E65100;"
                                    id="confirmPleUploadBtn">
                                    <i class="fas fa-upload me-1"></i> Upload & Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        @if(session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                confirmButtonColor: '#287C44',
                                confirmButtonText: 'OK'
                            });
                        @endif

                        @if(session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: '{{ session('error') }}',
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'OK'
                            });
                        @endif
                                                        });
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        document.querySelectorAll('[data-bs-target="#importUACEModal"]').forEach(button => {
                            button.addEventListener('click', function () {
                                const schoolId = this.getAttribute('data-school-id');
                                const schoolName = this.getAttribute('data-school-name');
                                const fileCategory = this.getAttribute('data-file-category');

                                console.log('UACE Import - School:', schoolName, 'ID:', schoolId);

                                // Set values in modal
                                if (schoolId) {
                                    document.getElementById('uace_school_id').value = schoolId;
                                }
                                if (schoolName) {
                                    document.getElementById('uace_school_name_display').value = schoolName;
                                }

                                if (fileCategory) {
                                    document.getElementById('uace_file_category').value = fileCategory; // Set file category
                                }
                            });
                        });

                        document.querySelectorAll('[data-bs-target="#importUCEModal"]').forEach(button => {
                            button.addEventListener('click', function () {
                                const schoolId = this.getAttribute('data-school-id');
                                const schoolName = this.getAttribute('data-school-name');
                                const fileCategory = this.getAttribute('data-file-category');


                                console.log('UCE Import - School:', schoolName, 'ID:', schoolId);

                                // Set values in modal
                                if (schoolId) {
                                    document.getElementById('uce_school_id').value = schoolId;
                                }
                                if (schoolName) {
                                    document.getElementById('uce_school_name_display').value = schoolName;
                                }

                                if (fileCategory) {
                                    document.getElementById('uce_file_category').value = fileCategory;
                                }
                            });
                        });

                        document.getElementById('uace-file-input').addEventListener('change', function (e) {
                            const name = e.target.files[0]?.name;
                            if (name) {
                                document.getElementById('uace-label').innerText = name;
                                document.getElementById('uace-label').classList.add('text-primary');
                                document.getElementById('uace-sub-label').innerText = "File selected successfully";
                            }
                        });

                        document.getElementById('uce-file-input').addEventListener('change', function (e) {
                            const name = e.target.files[0]?.name;
                            if (name) {
                                document.getElementById('uce-label').innerText = name;
                                document.getElementById('uce-label').classList.add('text-info');
                                document.getElementById('uce-sub-label').innerText = "File selected successfully";
                            }
                        });

                        document.getElementById('importUACEForm').addEventListener('submit', function (e) {
                            const activeYear = "{{ Helper::active_year() }}";
                            if (activeYear === "No Active year Set") {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Active Academic Year',
                                    text: 'Please set an active academic year before importing.',
                                    confirmButtonColor: '#287C44',
                                    confirmButtonText: 'Set Active Year'
                                });
                                return false;
                            }

                            const fileInput = document.getElementById('uace-file-input');
                            if (!fileInput.files.length) {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No File Selected',
                                    text: 'Please select an Excel file to upload.',
                                    confirmButtonColor: '#0d6efd'
                                });
                                return false;
                            }

                            // Show confirmation dialog
                            e.preventDefault();

                            Swal.fire({
                                title: 'Confirm Import',
                                html: `Are you sure you want to import UACE exam results for <strong>${document.getElementById('uace_school_name_display').value}</strong>?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#0d6efd',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Yes, import now',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show simple loading SweetAlert
                                    Swal.fire({
                                        title: 'Uploading File',
                                        text: 'Please wait while we process your file...',
                                        icon: 'info',
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    // Disable submit button
                                    const btn = document.getElementById('confirmUACEUploadBtn');
                                    btn.disabled = true;
                                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

                                    // Now submit the form
                                    this.submit();
                                }
                            });
                        });

                        document.getElementById('importUCEForm').addEventListener('submit', function (e) {
                            const activeYear = "{{ Helper::active_year() }}";
                            if (activeYear === "No Active year Set") {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Active Academic Year',
                                    text: 'Please set an active academic year before importing.',
                                    confirmButtonColor: '#287C44',
                                    confirmButtonText: 'Set Active Year'
                                });
                                return false;
                            }

                            const fileInput = document.getElementById('uce-file-input');
                            if (!fileInput.files.length) {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No File Selected',
                                    text: 'Please select an Excel file to upload.',
                                    confirmButtonColor: '#0ea5e9'
                                });
                                return false;
                            }

                            // Show confirmation dialog
                            e.preventDefault(); // Prevent default only to show confirmation

                            Swal.fire({
                                title: 'Confirm Import',
                                html: `Are you sure you want to import UCE exam results for <strong>${document.getElementById('uce_school_name_display').value}</strong>?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#0ea5e9',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Yes, import now',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show simple loading SweetAlert
                                    Swal.fire({
                                        title: 'Uploading File',
                                        text: 'Please wait while we process your file...',
                                        icon: 'info',
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    // Disable submit button
                                    const btn = document.getElementById('confirmUCEUploadBtn');
                                    btn.disabled = true;
                                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

                                    // Now submit the form
                                    this.submit();
                                }
                            });
                        });

                        // Reset form when modal is closed
                        document.getElementById('importUACEModal').addEventListener('hidden.bs.modal', function () {
                            document.getElementById('importUACEForm').reset();
                            document.getElementById('uace-label').innerText = 'Drop your Excel file here';
                            document.getElementById('uace-label').classList.remove('text-primary');
                            document.getElementById('uace-sub-label').innerText = 'or click to browse computer';
                            document.getElementById('uace_school_name_display').value = '';
                            document.getElementById('uace_file_category').value = '';
                            const btn = document.getElementById('confirmUACEUploadBtn');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload & Process';
                        });

                        document.getElementById('importUCEModal').addEventListener('hidden.bs.modal', function () {
                            document.getElementById('importUCEForm').reset();
                            document.getElementById('uce-label').innerText = 'Drop your Excel file here';
                            document.getElementById('uce-label').classList.remove('text-info');
                            document.getElementById('uce-sub-label').innerText = 'or click to browse computer';
                            document.getElementById('uce_school_name_display').value = '';
                            document.getElementById('uce_file_category').value = '';
                            const btn = document.getElementById('confirmUCEUploadBtn');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload & Process';
                        });
                    });

                    // Add this to your JavaScript to handle form submission responses
                    // You can add this after your existing JavaScript

                    // Handle form submission response
                    function handleFormResponse(formId) {
                        const form = document.getElementById(formId);

                        form.addEventListener('ajax:success', function (event) {
                            const [data, status, xhr] = event.detail;

                            Swal.fire({
                                icon: 'success',
                                title: 'Upload Successful!',
                                text: data.message || 'File uploaded successfully',
                                confirmButtonColor: '#287C44'
                            }).then(() => {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById(formId.includes(
                                    'uace') ? 'importUACEModal' : 'importUCEModal'));
                                modal.hide();

                                // Optional: Refresh page or update UI
                                window.location.reload();
                            });
                        });

                        form.addEventListener('ajax:error', function (event) {
                            const [xhr, status, error] = event.detail;

                            Swal.fire({
                                icon: 'error',
                                title: 'Upload Failed',
                                text: xhr.responseJSON?.message || 'An error occurred during upload',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                    }
                </script>

                <!-- Add this JavaScript after your existing script -->
                <script>
                    // Set school ID when import buttons are clicked
                    document.querySelectorAll('[data-bs-target="#importUACEModal"]').forEach(button => {
                        button.addEventListener('click', function () {
                            const schoolCard = this.closest('.school-card');
                            const schoolId = schoolCard.querySelector('.export-btn').href.match(/schoolId=([^&]*)/)[1];
                            document.getElementById('uace_school_id').value = schoolId;
                        });
                    });

                    document.querySelectorAll('[data-bs-target="#importUCEModal"]').forEach(button => {
                        button.addEventListener('click', function () {
                            const schoolCard = this.closest('.school-card');
                            const schoolId = schoolCard.querySelector('.export-btn').href.match(/schoolId=([^&]*)/)[1];
                            document.getElementById('uce_school_id').value = schoolId;
                        });
                    });

                    // File input handlers
                    document.getElementById('uace-file-input').addEventListener('change', function (e) {
                        const name = e.target.files[0]?.name;
                        if (name) {
                            document.getElementById('uace-label').innerText = name;
                            document.getElementById('uace-label').classList.add('text-primary');
                            document.getElementById('uace-sub-label').innerText = "File selected successfully";
                        }
                    });

                    document.getElementById('uce-file-input').addEventListener('change', function (e) {
                        const name = e.target.files[0]?.name;
                        if (name) {
                            document.getElementById('uce-label').innerText = name;
                            document.getElementById('uce-label').classList.add('text-info');
                            document.getElementById('uce-sub-label').innerText = "File selected successfully";
                        }
                    });

                    // Form submission handlers
                    document.getElementById('importUACEForm').addEventListener('submit', function (e) {
                        e.preventDefault();

                        const activeYear = "{{ Helper::active_year() }}";
                        if (activeYear === "No Active year Set") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Active Academic Year',
                                text: 'Please set an active academic year before importing.',
                                confirmButtonColor: '#287C44',
                                confirmButtonText: 'Set Active Year'
                            });
                            return false;
                        }

                        Swal.fire({
                            title: 'Confirm Import',
                            html: 'Are you sure you want to import UACE exam results?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, import',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const btn = document.getElementById('confirmUACEUploadBtn');
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
                                this.submit();
                            }
                        });
                    });

                    document.getElementById('importUCEForm').addEventListener('submit', function (e) {
                        e.preventDefault();

                        const activeYear = "{{ Helper::active_year() }}";
                        if (activeYear === "No Active year Set") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Active Academic Year',
                                text: 'Please set an active academic year before importing.',
                                confirmButtonColor: '#287C44',
                                confirmButtonText: 'Set Active Year'
                            });
                            return false;
                        }

                        Swal.fire({
                            title: 'Confirm Import',
                            html: 'Are you sure you want to import UCE exam results?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#0ea5e9',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, import',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const btn = document.getElementById('confirmUCEUploadBtn');
                                btn.disabled = true;
                                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
                                this.submit();
                            }
                        });
                    });

                    // Reset form when modal is closed
                    document.getElementById('importUACEModal').addEventListener('hidden.bs.modal', function () {
                        document.getElementById('importUACEForm').reset();
                        document.getElementById('uace-label').innerText = 'Drop your Excel file here';
                        document.getElementById('uace-label').classList.remove('text-primary');
                        document.getElementById('uace-sub-label').innerText = 'or click to browse computer';
                        document.getElementById('confirmUACEUploadBtn').disabled = false;
                        document.getElementById('confirmUACEUploadBtn').innerHTML =
                            '<i class="fas fa-upload me-1"></i> Upload & Process';
                    });

                    document.getElementById('importUCEModal').addEventListener('hidden.bs.modal', function () {
                        document.getElementById('importUCEForm').reset();
                        document.getElementById('uce-label').innerText = 'Drop your Excel file here';
                        document.getElementById('uce-label').classList.remove('text-info');
                        document.getElementById('uce-sub-label').innerText = 'or click to browse computer';
                        document.getElementById('confirmUCEUploadBtn').disabled = false;
                        document.getElementById('confirmUCEUploadBtn').innerHTML =
                            '<i class="fas fa-upload me-1"></i> Upload & Process';
                    });
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        document.querySelectorAll('.upload-blocked-btn').forEach(button => {
                            button.addEventListener('click', function () {

                                let type = this.dataset.type;

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Upload Not Active',
                                    text: type.charAt(0).toUpperCase() + type.slice(1) +
                                        ' upload is not currently active.',
                                    confirmButtonColor: '#287C44'
                                });

                            });
                        });

                    });
                </script>
            </div>
        </div>

    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        // PLE upload button handlers
        document.querySelectorAll('.upload-btn-ple, .upload-confirm-btn-ple').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var schoolId = this.getAttribute('data-school-id');
                var schoolName = this.getAttribute('data-school-name');
                document.getElementById('ple_school_id').value = schoolId;
                document.getElementById('ple_school_name_display').value = schoolName;
                // Open the PLE modal
                var modalEl = document.getElementById('importPleModal');
                if (typeof bootstrap !== 'undefined') {
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                } else if (typeof $ !== 'undefined') {
                    $('#importPleModal').modal('show');
                }
            });
        });

        // PLE file input label update
        var pleFileInput = document.getElementById('ple-file-input');
        if (pleFileInput) {
            pleFileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    var name = this.files[0].name;
                    document.getElementById('ple-label').innerText = name;
                    document.getElementById('ple-label').classList.add('text-info');
                    document.getElementById('ple-sub-label').innerText = 'File selected successfully';
                }
            });
        }
    </script>
@endsection