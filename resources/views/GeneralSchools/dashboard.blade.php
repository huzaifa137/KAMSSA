@extends('layouts-side-bar.master')

@section('content')
    <div class="side-app">
        <div class="container-fluid mt-3">

            <style>
                .sd-hero {
                    background: linear-gradient(135deg, #0b6b3a 0%, #0f8a4d 100%);
                    border-radius: 14px;
                    color: #fff;
                    padding: 28px 30px;
                    margin-bottom: 26px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: wrap;
                    gap: 16px;
                }

                .sd-hero h3 {
                    font-weight: 700;
                    margin-bottom: 4px;
                }

                .sd-hero p {
                    opacity: .9;
                    margin-bottom: 0;
                }

                .sd-hero .sd-badge {
                    background: rgba(255, 255, 255, .16);
                    border: 1px solid rgba(255, 255, 255, .3);
                    border-radius: 50px;
                    padding: 8px 18px;
                    font-weight: 600;
                    font-size: .9rem;
                    white-space: nowrap;
                    backdrop-filter: blur(4px);
                }

                .sd-stat {
                    border: 1px solid #e7ebf0;
                    border-radius: 16px;
                    background: #fff;
                    padding: 20px 22px;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    transition: all .18s ease;
                }

                .sd-stat:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 12px 26px rgba(15, 138, 77, .12);
                    border-color: #0f8a4d;
                }

                .sd-stat .sd-icon {
                    width: 52px;
                    height: 52px;
                    min-width: 52px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 22px;
                    color: #fff;
                }

                .sd-icon.bg-students {
                    background: linear-gradient(135deg, #1c6fd6, #0d4ea3);
                }

                .sd-icon.bg-graded {
                    background: linear-gradient(135deg, #0f8a4d, #0b6b3a);
                }

                .sd-icon.bg-pending {
                    background: linear-gradient(135deg, #e08e0b, #b56d02);
                }

                .sd-icon.bg-average {
                    background: linear-gradient(135deg, #8e44ad, #5b2c6f);
                }

                .sd-stat .sd-number {
                    font-size: 1.6rem;
                    font-weight: 700;
                    line-height: 1.15;
                    color: #1e293b;
                }

                .sd-stat .sd-label {
                    font-size: .78rem;
                    text-transform: uppercase;
                    letter-spacing: .04em;
                    color: #6b7785;
                    font-weight: 600;
                }

                .sd-card {
                    border: 1px solid #e7ebf0;
                    border-radius: 16px;
                    background: #fff;
                    overflow: hidden;
                }

                .sd-card .sd-card-header {
                    padding: 18px 24px;
                    border-bottom: 1px solid #e7ebf0;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .sd-card .sd-card-header h5 {
                    margin: 0;
                    font-weight: 700;
                    color: #1e293b;
                    font-size: 1.05rem;
                }

                .sd-card .sd-card-header i {
                    color: #0f8a4d;
                }

                .sd-card .sd-card-body {
                    padding: 24px;
                }

                .sd-locked-school {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    background: #f0f7f3;
                    border: 1px solid #d7ead9;
                    border-radius: 12px;
                    padding: 12px 16px;
                    height: 100%;
                }

                .sd-locked-school i {
                    color: #0b6b3a;
                    font-size: 1.2rem;
                }

                .sd-locked-school .name {
                    font-weight: 700;
                    color: #1e293b;
                    font-size: .95rem;
                    line-height: 1.2;
                }

                .sd-locked-school .code {
                    font-size: .78rem;
                    color: #6b7785;
                }

                .form-label {
                    font-size: 0.85rem;
                    margin-bottom: 0.35rem;
                    font-weight: 600;
                    color: #495057;
                }

                .form-select,
                .form-control {
                    border-radius: 0.6rem;
                    border: 1px solid #dee2e6;
                    padding: 0.55rem 0.75rem;
                    font-size: 0.95rem;
                }

                .form-select:focus,
                .form-control:focus {
                    border-color: #0f8a4d;
                    box-shadow: 0 0 0 0.2rem rgba(15, 138, 77, .12);
                }

                .sd-submit-btn {
                    background: linear-gradient(135deg, #0f8a4d, #0b6b3a);
                    border: none;
                    color: #fff;
                    font-weight: 600;
                    border-radius: 50px;
                    padding: 0.7rem 2rem;
                    box-shadow: 0 6px 16px rgba(15, 138, 77, .28);
                    transition: all .18s ease;
                }

                .sd-submit-btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 22px rgba(15, 138, 77, .34);
                    color: #fff;
                }

                @media (max-width: 767px) {
                    .sd-hero {
                        padding: 22px;
                    }

                    .sd-stat {
                        padding: 16px;
                    }
                }
            </style>

            {{-- Hero --}}
            <div class="sd-hero">
                <div>
                    <h3><i class="fas fa-school me-2"></i> School Dashboard</h3>
                    <p>Grading &amp; examination overview for {{ session('LoggedSchoolName') ?? 'your school' }}</p>
                </div>
                <div class="sd-badge">
                    <i class="fas fa-shield-halved me-1"></i>
                    {{ session('LoggedSchoolName') ?? 'School' }} &middot; {{ session('LoggedSchoolCode') }}
                </div>
            </div>

            {{-- Stats --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="sd-stat">
                        <div class="sd-icon bg-students"><i class="fas fa-user-graduate"></i></div>
                        <div>
                            <div class="sd-number">{{ number_format($totalStudents ?? 0) }}</div>
                            <div class="sd-label">Total Students</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="sd-stat">
                        <div class="sd-icon bg-graded"><i class="fas fa-circle-check"></i></div>
                        <div>
                            <div class="sd-number">{{ number_format($gradedSoFar ?? 0) }}</div>
                            <div class="sd-label">Graded So Far</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="sd-stat">
                        <div class="sd-icon bg-pending"><i class="fas fa-hourglass-half"></i></div>
                        <div>
                            <div class="sd-number">{{ number_format($pendingGrading ?? 0) }}</div>
                            <div class="sd-label">Pending Grading</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="sd-stat">
                        <div class="sd-icon bg-average"><i class="fas fa-chart-line"></i></div>
                        <div>
                            <div class="sd-number">{{ number_format($avgPerformance ?? 0, 1) }}%</div>
                            <div class="sd-label">Avg. Performance</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grading Report Form --}}
            <div class="sd-card">
                <div class="sd-card-header">
                    <i class="fas fa-calculator"></i>
                    <h5>Generate Grading Report</h5>
                </div>
                <div class="sd-card-body">
                    <form action="{{ route('school.process.grading') }}" method="POST" id="gradingFilterForm">
                        @csrf

                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Year <span class="text-danger">*</span></label>
                                <select name="year" class="form-select select2" required>
                                    <option value="">-- Select Year --</option>
                                    @foreach ($academicYears as $academicYear)
                                        <option value="{{ $academicYear->year_en }}" {{ $academicYear->year_en == $activeYear ? 'selected' : '' }}>
                                            {{ $academicYear->year_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select select2" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="level" id="levelInput">
                        </div>

                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-4 text-center">
                                <button type="submit" class="btn sd-submit-btn w-100">
                                    <i class="fas fa-magnifying-glass-chart me-2"></i>
                                    Generate School Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('gradingFilterForm');
            const categorySelect = document.querySelector('select[name="category"]');
            const levelInput = document.getElementById('levelInput');

            // UCE -> Level O, UACE -> Level A, derived automatically from Category.
            function setLevelBasedOnCategory() {
                if (!categorySelect || !levelInput) return;
                const selectedCategory = categorySelect.value;
                if (selectedCategory === 'UACE') {
                    levelInput.value = 'A';
                } else if (selectedCategory === 'UCE') {
                    levelInput.value = 'O';
                } else {
                    levelInput.value = '';
                }
            }

            if (categorySelect) {
                categorySelect.addEventListener('change', setLevelBasedOnCategory);
            }
            setLevelBasedOnCategory();

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Generating grading report. Please wait.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading(),
                    });
                    setTimeout(() => form.submit(), 300);
                });
            }
        });
    </script>
@endsection