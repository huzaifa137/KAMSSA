@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">

        <style>
            .stats-card {
                border-radius: 20px;
                overflow: hidden;
                transition: all 0.3s ease;
                border: none;
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            }

            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2) !important;
            }

            .stats-card .card-body {
                padding: 1.8rem 1.5rem;
                min-height: 160px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .stats-icon-wrapper {
                width: 60px;
                height: 60px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1.2rem;
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .stats-icon-wrapper i {
                color: white;
                opacity: 0.9;
            }

            .stats-content {
                flex: 1;
            }

            .stats-label {
                display: block;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }

            .stats-number {
                font-size: 2.5rem;
                font-weight: 700;
                line-height: 1.2;
                margin-bottom: 0.5rem;
            }

            .bg-gradient-primary {
                background: linear-gradient(0, #026837 0%, #026837 100%);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, #c51619 0%, #c51619 100%);
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, #026837 0%, #026837 100%);
            }

            @media (max-width: 768px) {
                .stats-card .card-body {
                    padding: 1.5rem;
                }

                .stats-icon-wrapper {
                    width: 50px;
                    height: 50px;
                }

                .stats-number {
                    font-size: 2rem;
                }
            }

            .stats-card:hover .stats-icon-wrapper {
                transform: scale(1.1);
                transition: transform 0.3s ease;
            }

            .stats-card::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100%;
                height: 100%;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><path d="M10 10 L90 10 L90 90 L10 90 Z" fill="none" stroke="white" stroke-width="2"/></svg>');
                opacity: 0.1;
                pointer-events: none;
            }

            .form-label {
                font-size: 0.9rem;
                margin-bottom: 0.25rem;
                font-weight: 600;
                color: #495057;
                white-space: nowrap;
            }

            .form-select,
            .form-control {
                border-radius: 0.5rem;
                border: 1px solid #dee2e6;
                padding: 0.5rem 0.75rem;
                transition: all 0.2s;
                font-size: 0.95rem;
                width: 100%;
            }

            .form-select:focus,
            .form-control:focus {
                border-color: #c51619;
                box-shadow: 0 0 0 0.2rem rgba(40, 124, 68, 0.1);
            }

            .card {
                border-radius: 1rem;
                overflow: hidden;
                border: none;
            }

            .card-header {
                border-bottom: none;
                padding: 1rem 1.5rem;
            }

            .badge {
                padding: 0.5rem 0.75rem;
                font-weight: 500;
                border-radius: 2rem;
            }

            .btn {
                border-radius: 2rem;
                font-weight: 500;
                padding: 0.5rem 1.5rem;
            }

            h5 {
                font-weight: 600;
                font-size: 1.1rem;
                color: #2c3e50;
            }

            .border-bottom {
                border-color: #e9ecef !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
            }

            /* Custom styling for select dropdowns with long text */
            select.form-select option {
                max-width: 100%;
                white-space: normal;
                word-wrap: break-word;
                padding: 8px;
            }

            /* Style for the optional badge */
            small.text-muted {
                font-size: 0.75rem;
                display: block;
                margin-top: 0.25rem;
                opacity: 0.8;
                font-style: italic;
            }

            /* ===== BALANCED SPACING FIX ===== */

            /* Remove extra padding and margins */
            .row.g-3 {
                margin-left: -8px;
                margin-right: -8px;
            }

            .row.g-3>[class*="col-"] {
                padding-left: 8px;
                padding-right: 8px;
                margin-bottom: 0.5rem;
            }

            /* Specific column widths with balanced spacing */
            @media (min-width: 768px) {

                /* Year field - 23% width */
                .col-md-3 {
                    flex: 0 0 auto;
                    width: 23%;
                }

                /* Category field - 23% width */
                .col-md-3:nth-child(2) {
                    width: 23%;
                }

                /* School field - 32% width (more space for long names) */
                .col-md-4 {
                    flex: 0 0 auto;
                    width: 32%;
                }

                /* Level field - 22% width */
                .col-md-2 {
                    flex: 0 0 auto;
                    width: 22%;
                }

                /* Remove the vertical dividers */
                .row.g-3>[class*="col-"]:not(:last-child)::after {
                    display: none;
                }

                /* Add subtle spacing between fields */
                .row.g-3>[class*="col-"] {
                    position: relative;
                }

                /* Optional: Very subtle right border for separation */
                .row.g-3>[class*="col-"]:not(:last-child) {
                    border-right: 1px solid rgba(222, 226, 230, 0.3);
                }

                /* Remove the left padding from level field */
                .col-md-2 {
                    padding-left: 8px !important;
                }

                /* Remove the special background from level field */
                .col-md-2 .form-select {
                    background-color: #ffffff;
                    border-left-width: 1px;
                }
            }

            /* Mobile responsiveness */
            @media (max-width: 767px) {
                .row.g-3>[class*="col-"] {
                    width: 100%;
                    margin-bottom: 1rem;
                }

                .col-md-2 {
                    margin-top: 0;
                    padding-top: 0;
                    border-top: none;
                }
            }

            /* Better visual hierarchy with subtle box shadows on focus */
            .form-select:focus {
                position: relative;
                z-index: 1;
            }

            /* Hover effect */
            .form-select:hover,
            .form-control:hover {
                border-color: #c51619;
            }

            /* Button hover effect */
            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn:active {
                transform: translateY(0);
            }

            /* Subject tables styling */
            .card-header {
                font-weight: 600;
                padding: 1rem 1.5rem;
            }

            .card-header.bg-success {
                background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
            }

            .card-header.bg-danger {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            }

            .table td {
                vertical-align: middle;
                padding: 0.75rem;
            }

            .table tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.02);
            }

            /* Subject badges */
            .badge.bg-success {
                background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
                padding: 0.4rem 0.6rem;
                font-size: 0.85rem;
            }

            .badge.bg-warning {
                color: #212529 !important;
                padding: 0.4rem 0.6rem;
                font-size: 0.85rem;
            }

            .badge.bg-info {
                background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
                padding: 0.4rem 0.6rem;
                font-size: 0.85rem;
            }

            .badge.bg-danger {
                padding: 0.4rem 0.6rem;
                font-size: 0.85rem;
            }

            /* Bronze badge for 3rd place */
            .badge.bg-bronze {
                background-color: #cd7f32 !important;
                color: white;
            }

            /* Responsive button styles */
            @media (max-width: 767px) {
                .col-md-4 .btn {
                    width: 100%;
                    white-space: normal;
                    word-wrap: break-word;
                    font-size: 14px;
                    padding: 10px 12px;
                    height: auto;
                    min-height: 44px;
                    /* Better touch target */
                }

                /* Ensure the button container takes full width on mobile */
                .col-12.col-md-4 {
                    width: 100%;
                }

                /* Adjust icon margin for better spacing */
                .btn i {
                    margin-right: 8px;
                }
            }

            /* For very small screens */
            @media (max-width: 480px) {
                .col-md-4 .btn {
                    font-size: 13px;
                    padding: 8px 10px;
                }
            }
        </style>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <div class="container mt-4">


            <div class="card shadow-lg border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background-color: #c51619;">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Grading & Examination Summary
                    </h4>
                </div>

                <div class="card-body">

                    <!-- Grading Summary Form -->
                    <div class="mb-4 pb-3 mt-4 border-bottom">
                        <h5 class="mb-3" style="color: #c51619">
                            <i class="fas fa-calculator me-2"></i> Schools Grading Report
                        </h5>

                        <form action="{{ route('school.process.grading') }}" method="POST" id="gradingFilterForm">
                            @csrf

                            <div class="row g-3">

                                <!-- Year -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold">
                                        Year <span class="text-danger">*</span>
                                    </label>
                                    <select name="year" class="form-select select2" required style="height: 38px;">
                                        <option value="">-- Select Year --</option>
                                        @foreach ($academicYears as $academicYear)
                                            <option value="{{ $academicYear->year_en }}" {{ $academicYear->year_en == $activeYear ? 'selected' : '' }}>
                                                {{ $academicYear->year_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Category -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold">
                                        Category <span class="text-danger">*</span>
                                    </label>
                                    <select name="category" class="form-select select2" required style="height: 38px;">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }} ({{ $key }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- School -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold">School</label>
                                    <select name="school_number" class="form-select select2" style="height: 38px;" required>
                                        <option value="{{ session('LoggedSchoolCode') }}" selected>
                                            {{ session('LoggedSchoolName') }} ({{ session('LoggedSchoolCode') }})
                                        </option>
                                    </select>
                                    <div style="height: 21px;">
                                    </div>
                                </div>

                                <input type="hidden" name="level" id="levelInput">
                            </div>

                            <!-- Centered Button Row -->
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-4">
                                    <button type="submit" class="btn"
                                        style="background-color: #c51619; color: white; width: 100%; min-height: 44px;">
                                        <i class="fas fa-magnifying-glass-chart me-2"></i>
                                        Generate School Report
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- Quick Stats Preview -->
                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-md-3 col-6">
                            <div class="bg-light p-2 rounded text-center">
                                <small class="text-muted">Total Schools</small>
                                <h6 class="mb-0">{{ count($schools ?? []) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-light p-2 rounded text-center">
                                <small class="text-muted">Categories</small>
                                <h6 class="mb-0">{{ count($categories ?? []) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-light p-2 rounded text-center">
                                <small class="text-muted">Years Active</small>
                                <h6 class="mb-0">{{ count($years ?? []) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-light p-2 rounded text-center">
                                <small class="text-muted">Last Search</small>
                                <h6 class="mb-0">{{ now()->format('M d, Y') }}</h6>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handle first form (Grading Report)
        document.getElementById('gradingFilterForm').addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Processing...',
                text: 'Generating grading report. Please wait.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                e.target.submit();
            }, 300);
        });

        // Handle second form (Examination Statistics)
        document.querySelector('form[action="{{ route('iteb.exam.statistics') }}"]').addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Processing...',
                text: 'Generating examination statistics. Please wait.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                e.target.submit();
            }, 300);
        });

        // Category and level handling (single implementation)
        document.addEventListener("DOMContentLoaded", function () {
            const categorySelect = document.querySelector('select[name="category"]');
            const levelInput = document.getElementById('levelInput');

            if (categorySelect && levelInput) {
                function setLevelBasedOnCategory() {
                    const selectedCategory = categorySelect.value;

                    if (selectedCategory === 'TH') {
                        levelInput.value = 'A'; // Thanawi → Level A
                    } else if (selectedCategory === 'ID') {
                        levelInput.value = 'O'; // Idaad → Level O
                    } else {
                        levelInput.value = '';
                    }
                }

                // When category changes
                categorySelect.addEventListener('change', setLevelBasedOnCategory);

                // Set automatically on page load
                setLevelBasedOnCategory();
            }
        });
    </script>
@endsection