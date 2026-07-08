{{-- resources/views/itemGrading/analytics/dashboard.blade.php --}}
@extends('layouts-side-bar.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="side-app">
    <div class="container-fluid mt-4">
        
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Analytics & Reports Dashboard
                            </h3>
                            <div>
                                <button class="btn btn-light btn-sm" onclick="refreshDashboard()">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            @csrf
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Year</label>
                                <select name="year" id="yearSelect" class="form-control" required>
                                    <option value="">Select Year</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category" id="categorySelect" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Level</label>
                                <select name="level" id="levelSelect" class="form-control">
                                    <option value="A">Level A</option>
                                    <option value="O">Level O</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">School (Optional)</label>
                                <select name="school_number" id="schoolSelect" class="form-control">
                                    <option value="">All Schools</option>
                                    @foreach($schools as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-primary" onclick="loadAllData()">
                                    <i class="fas fa-search"></i> Generate Reports
                                </button>
                                <button type="button" class="btn btn-success" onclick="exportReport()">
                                    <i class="fas fa-download"></i> Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats Cards --}}
        <div class="row mb-4" id="quickStats">
            @include('itemGrading.analytics.partials.quick-stats', ['stats' => $quickStats])
        </div>

        {{-- Main Dashboard Content --}}
        <div class="row">
            {{-- School Ranking Section --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-school me-2"></i>School Rankings</h5>
                        <button class="btn btn-sm btn-light" onclick="refreshSection('school')">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="card-body" id="schoolRankingContent">
                        @include('itemGrading.analytics.partials.loading')
                    </div>
                </div>
            </div>

            {{-- Top Students Section --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-trophy me-2"></i> Top Performers</h5>
                        <button class="btn btn-sm btn-light" onclick="refreshSection('students')">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="card-body" id="topStudentsContent">
                        @include('itemGrading.analytics.partials.loading')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Subject Analysis --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Subject Performance</h5>
                        <button class="btn btn-sm btn-light" onclick="refreshSection('subjects')">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="card-body" id="subjectAnalysisContent">
                        @include('itemGrading.analytics.partials.loading')
                    </div>
                </div>
            </div>

            {{-- Year Comparison --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Year-over-Year Comparison</h5>
                        <button class="btn btn-sm btn-light" onclick="refreshSection('comparison')">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="card-body" id="yearComparisonContent">
                        @include('itemGrading.analytics.partials.loading')
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Analysis Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <ul class="nav nav-tabs card-header-tabs" id="analyticsTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-dark" id="grade-dist-tab" data-bs-toggle="tab" href="#grade-dist" role="tab">
                                    Grade Distribution
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="trends-tab" data-bs-toggle="tab" href="#trends" role="tab">
                                    Performance Trends
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="comparison-tab" data-bs-toggle="tab" href="#comparison" role="tab">
                                    School Comparison
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="exports-tab" data-bs-toggle="tab" href="#exports" role="tab">
                                    Export Options
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="analyticsTabContent">
                            <div class="tab-pane fade show active" id="grade-dist" role="tabpanel">
                                <div id="gradeDistributionChart" style="height: 400px;">
                                    <canvas id="gradeDistCanvas"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="trends" role="tabpanel">
                                <div id="trendsChart" style="height: 400px;">
                                    <canvas id="trendsCanvas"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="comparison" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="schoolComparisonTable">
                                        <thead>
                                            <tr>
                                                <th>School</th>
                                                <th>Students</th>
                                                <th>Avg Score</th>
                                                <th>Pass Rate</th>
                                                <th>Top Grade</th>
                                                <th>Performance</th>
                                            </tr>
                                        </thead>
                                        <tbody id="comparisonTableBody">
                                            <tr><td colspan="6" class="text-center">Select filters to load data</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="exports" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                                <h6>Excel Report</h6>
                                                <button class="btn btn-sm btn-success" onclick="downloadReport('excel')">
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                                <h6>PDF Report</h6>
                                                <button class="btn btn-sm btn-danger" onclick="downloadReport('pdf')">
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-csv fa-3x text-primary mb-3"></i>
                                                <h6>CSV Report</h6>
                                                <button class="btn btn-sm btn-primary" onclick="downloadReport('csv')">
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-print fa-3x text-secondary mb-3"></i>
                                                <h6>Print Report</h6>
                                                <button class="btn btn-sm btn-secondary" onclick="window.print()">
                                                    Print
                                                </button>
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
    </div>
</div>

{{-- Include partials --}}
@include('itemGrading.analytics.partials.modals')
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize with default values if available
    var savedYear = localStorage.getItem('selectedYear');
    var savedCategory = localStorage.getItem('selectedCategory');
    
    if (savedYear && savedCategory) {
        $('#yearSelect').val(savedYear);
        $('#categorySelect').val(savedCategory);
        loadAllData();
    }
});

// Global chart instances
let gradeChart, trendsChart;

function loadAllData() {
    var year = $('#yearSelect').val();
    var category = $('#categorySelect').val();
    
    if (!year || !category) {
        alert('Please select year and category');
        return;
    }

    // Save to localStorage
    localStorage.setItem('selectedYear', year);
    localStorage.setItem('selectedCategory', category);

    // Show loading in all sections
    showLoading();

    // Load all sections
    loadSchoolRanking();
    loadTopStudents();
    loadSubjectAnalysis();
    loadYearComparison();
}

function showLoading() {
    $('.loading-spinner').show();
    $('#schoolRankingContent, #topStudentsContent, #subjectAnalysisContent, #yearComparisonContent')
        .html('<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading data...</p></div>');
}

function loadSchoolRanking() {
    var formData = $('#filterForm').serialize();
    
    $.ajax({
        url: '{{ route("iteb.analytics.school.ranking") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                displaySchoolRanking(response.data, response.summary);
                updateComparisonTable(response.data);
            }
        },
        error: function(xhr) {
            $('#schoolRankingContent').html('<div class="alert alert-danger">Error loading school data</div>');
        }
    });
}

function displaySchoolRanking(schools, summary) {
    var html = `
        <div class="mb-3">
            <div class="row g-2">
                <div class="col-6">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Total Schools</small>
                        <h6>${summary.total_schools}</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Top School</small>
                        <h6>${summary.top_school}</h6>
                    </div>
                </div>
            </div>
        </div>
    `;

    html += '<div class="table-responsive" style="max-height: 300px; overflow-y: auto;"><table class="table table-sm table-hover"><thead><tr><th>Rank</th><th>School</th><th>Avg %</th><th>Pass Rate</th><th>Trend</th></tr></thead><tbody>';
    
    schools.forEach(function(school) {
        var trendIcon = school.trend === 'up' ? '📈' : (school.trend === 'down' ? '📉' : '➡️');
        html += `
            <tr>
                <td><span class="badge bg-${school.rank <= 3 ? 'success' : 'secondary'}">#${school.rank}</span></td>
                <td>${school.school_name}</td>
                <td><strong>${school.average_percentage}%</strong></td>
                <td>${school.pass_rate}%</td>
                <td>${trendIcon}</td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    
    $('#schoolRankingContent').html(html);
}

function loadTopStudents() {
    var formData = $('#filterForm').serialize() + '&limit=50';
    
    $.ajax({
        url: '{{ route("iteb.analytics.student.ranking") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                displayTopStudents(response);
            }
        },
        error: function(xhr) {
            $('#topStudentsContent').html('<div class="alert alert-danger">Error loading student data</div>');
        }
    });
}

function displayTopStudents(data) {
    var html = `
        <div class="mb-3">
            <div class="row g-2">
                <div class="col-4">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Total</small>
                        <h6>${data.statistics.total_students}</h6>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Average</small>
                        <h6>${data.statistics.average_percentage.toFixed(2)}%</h6>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Top Score</small>
                        <h6>${data.statistics.highest_score}%</h6>
                    </div>
                </div>
            </div>
        </div>
    `;

    html += '<h6 class="text-success">🏆 Top 10 Performers</h6>';
    html += '<div class="table-responsive" style="max-height: 200px; overflow-y: auto;"><table class="table table-sm"><thead><tr><th>#</th><th>Student</th><th>School</th><th>%</th><th>Grade</th></tr></thead><tbody>';
    
    data.top_students.slice(0, 10).forEach(function(student) {
        html += `
            <tr>
                <td>${student.rank}</td>
                <td>${student.student_id}</td>
                <td>${student.school}</td>
                <td><span class="badge bg-success">${student.percentage}%</span></td>
                <td>${student.grade}</td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    
    $('#topStudentsContent').html(html);
}

function loadSubjectAnalysis() {
    var formData = $('#filterForm').serialize();
    
    $.ajax({
        url: '{{ route("iteb.analytics.subject.analysis") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                displaySubjectAnalysis(response);
                updateGradeChart(response.all_subjects);
            }
        },
        
error: function(data) {
$('body').html(data.responseText);
}
        // error: function(xhr) {
        //     $('#subjectAnalysisContent').html('<div class="alert alert-danger">Error loading subject data</div>');
        // }
    });
}

function displaySubjectAnalysis(data) {
    var html = `
        <div class="mb-3">
            <div class="row g-2">
                <div class="col-6">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Best Subject</small>
                        <h6>${data.summary.best_subject}</h6>
                        <small>${data.summary.best_subject_score}%</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-light p-2 rounded text-center">
                        <small>Worst Subject</small>
                        <h6>${data.summary.worst_subject}</h6>
                        <small>${data.summary.worst_subject_score}%</small>
                    </div>
                </div>
            </div>
        </div>
    `;

    html += '<div class="table-responsive" style="max-height: 200px; overflow-y: auto;"><table class="table table-sm"><thead><tr><th>Subject</th><th>Avg</th><th>Pass Rate</th></tr></thead><tbody>';
    
    data.all_subjects.slice(0, 8).forEach(function(subject) {
        var passClass = subject.pass_rate >= 70 ? 'success' : (subject.pass_rate >= 50 ? 'warning' : 'danger');
        html += `
            <tr>
                <td>${subject.subject_name}</td>
                <td><strong>${subject.average_mark}%</strong></td>
                <td><span class="badge bg-${passClass}">${subject.pass_rate}%</span></td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    
    $('#subjectAnalysisContent').html(html);
}

function loadYearComparison() {
    var year = $('#yearSelect').val();
    var years = [year, year-1, year-2].filter(y => y >= 2000);
    
    var formData = $('#filterForm').serialize() + '&years[]=' + years.join('&years[]=');
    
    $.ajax({
        url: '{{ route("iteb.analytics.year.comparison") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                displayYearComparison(response);
                updateTrendsChart(response.comparison);
            }
        },
        error: function(xhr) {
            $('#yearComparisonContent').html('<div class="alert alert-danger">Error loading comparison data</div>');
        }
    });
}

function displayYearComparison(data) {
    var html = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Year</th><th>Students</th><th>Avg %</th><th>Pass Rate</th></tr></thead><tbody>';
    
    data.comparison.forEach(function(item) {
        var change = '';
        if (item.year == data.comparison[data.comparison.length-1].year && data.trends.length > 0) {
            var trend = data.trends[data.trends.length-1];
            change = `<small class="text-${trend.average_change >= 0 ? 'success' : 'danger'}">(${trend.average_change >= 0 ? '+' : ''}${trend.average_change}%)</small>`;
        }
        
        html += `
            <tr>
                <td><strong>${item.year}</strong></td>
                <td>${item.total_students}</td>
                <td>${item.average_percentage.toFixed(2)}% ${change}</td>
                <td><span class="badge bg-${item.pass_rate >= 70 ? 'success' : (item.pass_rate >= 50 ? 'warning' : 'danger')}">${item.pass_rate.toFixed(2)}%</span></td>
            </tr>
        `;
    });
    
    html += '</tbody></table>';
    
    if (data.trends.length > 0) {
        var latest = data.trends[data.trends.length-1];
        html += `
            <div class="alert alert-${latest.average_change >= 0 ? 'success' : 'danger'} mt-2">
                <i class="fas fa-${latest.average_change >= 0 ? 'arrow-up' : 'arrow-down'}"></i>
                ${latest.average_change >= 0 ? 'Improvement' : 'Decline'} of ${Math.abs(latest.average_change)}% from previous year
            </div>
        `;
    }
    
    $('#yearComparisonContent').html(html);
}

function updateComparisonTable(schools) {
    var html = '';
    schools.slice(0, 10).forEach(function(school) {
        var perfClass = school.average_percentage >= 70 ? 'success' : (school.average_percentage >= 50 ? 'warning' : 'danger');
        html += `
            <tr>
                <td><strong>${school.school_name}</strong></td>
                <td>${school.total_students}</td>
                <td><span class="badge bg-${perfClass}">${school.average_percentage}%</span></td>
                <td>${school.pass_rate}%</td>
                <td>${Object.keys(school.grades)[0] || 'N/A'}</td>
                <td>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-${perfClass}" style="width: ${school.average_percentage}%"></div>
                    </div>
                </td>
            </tr>
        `;
    });
    
    $('#comparisonTableBody').html(html);
}

function updateGradeChart(subjects) {
    if (gradeChart) gradeChart.destroy();
    
    var ctx = document.getElementById('gradeDistCanvas').getContext('2d');
    var labels = subjects.map(s => s.subject_name.substring(0, 15) + '...');
    var data = subjects.map(s => s.average_mark);
    
    gradeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Average Mark (%)',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
}

function updateTrendsChart(comparison) {
    if (trendsChart) trendsChart.destroy();
    
    var ctx = document.getElementById('trendsCanvas').getContext('2d');
    var years = comparison.map(c => c.year);
    var averages = comparison.map(c => c.average_percentage);
    var passRates = comparison.map(c => c.pass_rate);
    
    trendsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [
                {
                    label: 'Average Score',
                    data: averages,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: 'Pass Rate',
                    data: passRates,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function refreshSection(section) {
    switch(section) {
        case 'school': loadSchoolRanking(); break;
        case 'students': loadTopStudents(); break;
        case 'subjects': loadSubjectAnalysis(); break;
        case 'comparison': loadYearComparison(); break;
    }
}

function refreshDashboard() {
    loadAllData();
}

function exportReport() {
    var year = $('#yearSelect').val();
    var category = $('#categorySelect').val();
    
    if (!year || !category) {
        alert('Please select year and category first');
        return;
    }
    
    var reportType = prompt('Enter report type (school, student, subject, year):', 'school');
    if (!reportType) return;
    
    var format = prompt('Enter format (excel, pdf, csv):', 'excel');
    if (!format) return;
    
    var formData = $('#filterForm').serialize() + '&report_type=' + reportType + '&format=' + format;
    
    $.ajax({
        url: '{{ route("iteb.analytics.export") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                window.location.href = response.download_url;
            }
        },
        error: function() {
            alert('Error generating report');
        }
    });
}

function downloadReport(format) {
    window.location.href = '{{ url("iteb.analytics.download", ["format" => ""]) }}/' + format;
}
</script>

<style>
.progress { height: 5px; margin-top: 5px; }
.card-header-tabs { margin-bottom: -0.75rem; }
.table-responsive { scrollbar-width: thin; }
.table-responsive::-webkit-scrollbar { width: 6px; }
.table-responsive::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
</style>

@push('scripts')

@endpush