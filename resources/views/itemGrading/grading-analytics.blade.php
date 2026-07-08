{{-- resources/views/itemGrading/grading-results.blade.php --}}
@extends('layouts-side-bar.master')

{{-- Modern CSS Stack --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        --warning-gradient: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        --glass-bg: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.18);
        --shadow-color: rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
    }

    /* Glass Card Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.25);
    }

    /* Gradient Headers */
    .gradient-header {
        background: var(--primary-gradient);
        padding: 2rem;
        border-radius: 20px 20px 0 0;
        position: relative;
        overflow: hidden;
    }

    .gradient-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Statistics Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, transparent 50%, rgba(102, 126, 234, 0.1) 100%);
        border-radius: 50%;
    }

    .stat-card:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
    }

    /* Modern Filter Section - IMPROVED SPACING */
    .filter-section {
        background: white;
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .filter-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
    }

    .filter-label i {
        font-size: 1.1rem;
        width: 20px;
        color: #667eea;
    }

    .modern-input {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.875rem 1.25rem;
        transition: all 0.3s ease;
        background: white;
        font-size: 0.95rem;
        width: 100%;
    }

    .modern-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    /* Special styling for range inputs */
    .range-group {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 0.75rem;
        align-items: center;
    }

    .range-separator {
        color: #94a3b8;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Sort group styling */
    .sort-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    /* Action buttons section - IMPROVED */
    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px dashed #e2e8f0;
    }

    /* Button Styles */
    .modern-btn {
        padding: 0.875rem 2rem;
        border-radius: 14px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
        cursor: pointer;
    }

    .btn-primary-modern {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    .btn-secondary-modern {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-secondary-modern:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-success-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    /* Active filters badge */
    .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .active-filters-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 0.5rem 1.25rem;
        border-radius: 100px;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .active-filters-badge i {
        color: #667eea;
    }

    /* Table Styles */
    .modern-table {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        width: 100%;
    }

    .modern-table thead th {
        background: var(--primary-gradient);
        color: white;
        font-weight: 600;
        padding: 1rem;
        border: none;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
    }

    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }

    .modern-table td {
        padding: 1rem;
        vertical-align: middle;
    }

    /* Badge Styles */
    .performance-badge {
        padding: 0.5rem 1rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-block;
    }

    .badge-excellent {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #1e293b;
    }

    .badge-good {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        color: #1e293b;
    }

    .badge-average {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #1e293b;
    }

    .badge-poor {
        background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);
        color: #1e293b;
    }

    /* Responsive adjustments */
    @media (max-width: 1400px) {
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .modern-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Select2 customization */
    .select2-container--default .select2-selection--single {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        height: 50px;
        padding: 0.5rem 1rem;
    }
</style>

@section('content')
    <div class="container-fluid py-4">
        <!-- Animated Header -->
        <div class="glass-card mb-4">
            <div class="gradient-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="display-6 fw-bold text-white mb-2">
                            <i class="fas fa-chart-pie me-3"></i>Analytics Dashboard
                        </h1>
                        <p class="text-white-50 mb-0">Real-time performance monitoring & insights</p>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="badge bg-white text-primary p-3 rounded-pill">
                            <i class="fas fa-calendar me-2"></i> {{ now()->format('F j, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section with Improved Spacing -->
        <div class="filter-section animate__animated animate__fadeInUp">
            <div class="filters-header">
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-sliders-h text-primary me-2"></i> Smart Filters
                </h4>
                <div class="active-filters-badge" id="activeFiltersCount">
                    <i class="fas fa-filter"></i>
                    <span>0 Active Filters</span>
                </div>
            </div>

            <form id="advancedFilterForm">
                @csrf

                <!-- First Row - Basic Filters -->
                <div class="filter-grid">
                    <!-- Year Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Academic Year</span>
                        </label>
                        <select name="year" class="modern-input select2-modern">
                            <option value="All">All Years</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tag"></i>
                            <span>Category</span>
                        </label>
                        <select name="category" class="modern-input">
                            @foreach ($categories as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- School Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-school"></i>
                            <span>School/Institution</span>
                        </label>
                        <select name="school_number" class="modern-input select2-modern">
                            <option value="">All Schools</option>
                            @foreach ($schools as $code => $name)
                                <option value="{{ $code }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-venus-mars"></i>
                            <span>Gender</span>
                        </label>
                        <select name="gender" class="modern-input">
                            @foreach ($genders as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row - Advanced Filters -->
                <div class="filter-grid">
                    <!-- Subject Filter -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-book"></i>
                            <span>Subject</span>
                        </label>
                        <select name="subject_id" class="modern-input select2-modern">
                            <option value="">All Subjects</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Percentage Range -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-percent"></i>
                            <span>Percentage Range</span>
                        </label>
                        <div class="range-group">
                            <input type="number" name="min_percentage" class="modern-input" placeholder="Min"
                                min="0" max="100" step="0.1">
                            <span class="range-separator">to</span>
                            <input type="number" name="max_percentage" class="modern-input" placeholder="Max"
                                min="0" max="100" step="0.1">
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-sort-amount-down"></i>
                            <span>Sort Results</span>
                        </label>
                        <div class="sort-group">
                            <select name="sort_by" class="modern-input">
                                <option value="percentage">Percentage</option>
                                <option value="total_marks">Total Marks</option>
                                <option value="student_id">Student ID</option>
                            </select>
                            <select name="sort_order" class="modern-input">
                                <option value="desc">Highest First</option>
                                <option value="asc">Lowest First</option>
                            </select>
                        </div>
                    </div>

                    <!-- Result Limit -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-list-ol"></i>
                            <span>Number of Results</span>
                        </label>
                        <input type="number" name="limit" class="modern-input" value="100" min="1"
                            max="1000" step="1">
                    </div>
                </div>

                <!-- Action Buttons -->
                {{-- <div class="filter-actions">
                    <button type="button" class="modern-btn btn-secondary-modern" id="resetFilters">
                        <i class="fas fa-undo-alt"></i>
                        <span>Reset All</span>
                    </button>
                    <button type="button" class="modern-btn btn-success-modern" id="exportData">
                        <i class="fas fa-file-export"></i>
                        <span>Export Data</span>
                    </button>
                    <button type="submit" class="modern-btn btn-primary-modern" id="applyFilters">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </button>
                </div> --}}

                <div class="filter-actions">

                    <a href="javascript:void(0);" class="modern-btn btn-secondary-modern" id="resetFilters">
                        <i class="fas fa-undo-alt"></i>
                        <span>Reset All</span>
                    </a>

                    <a href="javascript:void(0);" class="modern-btn btn-success-modern" id="exportData">
                        <i class="fas fa-file-export"></i>
                        <span>Export Data</span>
                    </a>

                    <a href="javascript:void(0);" class="modern-btn btn-primary-modern" id="applyFilters">
                        <i class="fas fa-search"></i>
                        <span>Apply Filters</span>
                    </a>

                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4" id="statisticsContainer">
            <!-- Statistics cards will be loaded here -->
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="glass-card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-chart-bar text-primary me-2"></i> Grade Distribution
                        </h5>
                        <span class="badge bg-light text-dark p-2">Updated real-time</span>
                    </div>
                    <canvas id="gradeChart" height="300"></canvas>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="glass-card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-chart-pie text-success me-2"></i> Classification Distribution
                        </h5>
                    </div>
                    <canvas id="classificationChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performers Section -->
        <div class="glass-card mb-4">
            <div class="p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="fas fa-trophy text-warning me-2"></i> Top Performers
                        </h5>
                        <p class="text-muted small mb-0">Students with highest scores based on current filters</p>
                    </div>
                    {{-- <a href="{{ route('iteb.grading.top-performers') }}" class="modern-btn btn-primary-modern">
                        View Full Report <i class="fas fa-arrow-right ms-2"></i>
                    </a> --}}

                    <a href="javascript:void(0);" class="modern-btn btn-primary-modern">
                        View Full Report <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Student ID</th>
                                <th>School</th>
                                <th>Category</th>
                                <th>Year</th>
                                <th>Gender</th>
                                <th>Total Marks</th>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="topPerformersBody">
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Apply filters to see results</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Subject Analysis -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-star text-warning me-2"></i> Best Performing Subjects
                    </h5>
                    <canvas id="bestSubjectsChart" height="250"></canvas>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-check-circle text-success me-2"></i> Subject Pass Rates
                    </h5>
                    <canvas id="subjectPassRatesChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Gender Analysis -->
        <div class="glass-card mb-4">
            <div class="p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-venus-mars text-danger me-2"></i> Gender-Based Performance Analysis
                </h5>
                <div class="row">
                    <div class="col-lg-6">
                        <canvas id="genderChart" height="300"></canvas>
                    </div>
                    <div class="col-lg-6" id="genderStats">
                        <!-- Will be populated via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div class="modal fade" id="studentDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass-card border-0">
                <div class="modal-header gradient-header border-0">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-user-graduate me-2"></i>Student Performance Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="studentDetailsContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="modern-btn btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2-modern').select2({
                theme: 'default',
                width: '100%',
                dropdownAutoWidth: true
            });

            // Initialize charts
            initializeCharts();

            // Live filter counter
            $('.modern-input, select').on('change input', function() {
                updateFilterCount();
            });

            // Form submission
            $('#advancedFilterForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.html();

                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Applying...').prop('disabled', true);

                // Simulate API call (replace with actual AJAX)
                setTimeout(() => {
                    applyFilters();
                    btn.html(originalText).prop('disabled', false);
                }, 1000);
            });

            // Reset filters
            $('#resetFilters').on('click', function() {
                Swal.fire({
                    title: 'Reset all filters?',
                    text: 'This will clear all your current filter selections',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, reset'
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetAllFilters();
                    }
                });
            });

            // Export data
            $('#exportData').on('click', function() {
                Swal.fire({
                    title: 'Preparing export...',
                    html: 'Please wait while we generate your report',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Simulate export (replace with actual export)
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Export Complete',
                        text: 'Your file has been generated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }, 2000);
            });
        });

        function updateFilterCount() {
            let count = $('.modern-input, select').filter(function() {
                let val = $(this).val();
                return val && val !== 'All' && val !== '' && val !== '0' && val !== '100';
            }).length;

            $('#activeFiltersCount span').text(count + ' Active Filter' + (count !== 1 ? 's' : ''));

            if (count > 0) {
                $('#activeFiltersCount').addClass('bg-primary text-white').removeClass('bg-light text-dark');
            } else {
                $('#activeFiltersCount').removeClass('bg-primary text-white').addClass('bg-light text-dark');
            }
        }

        function resetAllFilters() {
            $('#advancedFilterForm')[0].reset();
            $('.select2-modern').val('').trigger('change');
            updateFilterCount();
            applyFilters();

            Swal.fire({
                icon: 'success',
                title: 'Filters Reset',
                text: 'All filters have been cleared',
                timer: 1500,
                showConfirmButton: false
            });
        }

        function applyFilters() {
            // Show loading state
            Swal.fire({
                title: 'Updating dashboard...',
                html: 'Fetching latest data based on your filters',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Simulate AJAX call (replace with actual)
            setTimeout(() => {
                Swal.close();

                // Show success message
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                toast.fire({
                    icon: 'success',
                    title: 'Dashboard updated successfully'
                });
            }, 1500);
        }

        function initializeCharts() {
            // Initialize empty charts
            window.gradeChart = new Chart(document.getElementById('gradeChart'), {
                type: 'bar',
                data: {
                    labels: ['A', 'B', 'C', 'D', 'F'],
                    datasets: [{
                        label: 'Number of Students',
                        data: [0, 0, 0, 0, 0],
                        backgroundColor: 'rgba(102, 126, 234, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            window.classificationChart = new Chart(document.getElementById('classificationChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Distinction', 'Merit', 'Pass', 'Fail'],
                    datasets: [{
                        data: [0, 0, 0, 0],
                        backgroundColor: [
                            'rgba(132, 250, 176, 0.8)',
                            'rgba(143, 211, 244, 0.8)',
                            'rgba(246, 211, 101, 0.8)',
                            'rgba(253, 160, 133, 0.8)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    </script>
@endpush
